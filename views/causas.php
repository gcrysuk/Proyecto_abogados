<?php
ob_start();
// views/causas.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Causas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        width: 400px;
        max-width: 90%;
    }

    .popup-header {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .popup button {
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup button:hover {
        background-color: #0056b3;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .add-causa-btn {
        display: flex;
        align-items: center;
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .add-causa-btn i {
        margin-right: 5px;
    }

    .add-causa-btn:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <a href="../index.php"
        style="display: inline-block; margin-bottom: 20px; background-color: #007BFF; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;"><i
            class='fas fa-home'></i> Inicio</a>
    <header>Gestión de Causas</header>

    <!-- Botón para abrir el formulario en un popup -->
    <div class="add-causa-btn" onclick="openPopup()">
        <i class="fas fa-folder-plus"></i> Agregar Causa
    </div>

    <!-- Popup para agregar causa -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
        <div class="popup-header">Agregar Causa</div>
        <form action="causas.php" method="POST">
            <label for="numero_expediente">Número de Expediente:</label>
            <input type="text" id="numero_expediente" name="numero_expediente" required>

            <label for="cliente_dni">Cliente (DNI):</label>
            <select id="cliente_dni" name="cliente_dni" required>
                <?php
                $clientes = $conn->query("SELECT DNI, Nombre FROM Clientes");
                while ($cliente = $clientes->fetch_assoc()) {
                    echo "<option value='{$cliente['DNI']}'>DNI: {$cliente['DNI']} - {$cliente['Nombre']}</option>";
                }
                ?>
                <option value="add">Agregar un nuevo cliente</option>
            </select>

            <label for="juzgado_id">Juzgado:</label>
            <select id="juzgado_id" name="juzgado_id" required>
                <?php
                $juzgados = $conn->query("SELECT ID, Nombre FROM Juzgados");
                while ($juzgado = $juzgados->fetch_assoc()) {
                    echo "<option value='{$juzgado['ID']}'>{$juzgado['Nombre']}</option>";
                }
                ?>
            </select>

            <label for="objeto_id">Objeto:</label>
            <select id="objeto_id" name="objeto_id" required>
                <?php
                $objetos = $conn->query("SELECT ID, Descripcion FROM Objeto");
                while ($objeto = $objetos->fetch_assoc()) {
                    echo "<option value='{$objeto['ID']}'>{$objeto['Descripcion']}</option>";
                }
                ?>
            </select>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea>

            <label for="fecha_alta">Fecha de Alta:</label>
            <input type="date" id="fecha_alta" name="fecha_alta" required>

            <button type="submit" name="agregar">Agregar Causa</button>
            <button type="button" onclick="closePopup()">Cancelar</button>
        </form>
    </div>

    <hr>

    <!-- Lista de causas -->
    <h2>Lista de Causas</h2>
    <table>
        <div class="filter-container" style="margin-bottom: 15px; display: flex; gap: 10px;">
            <input type="text" id="filterNumero" placeholder="Filtrar por Número de Expediente" oninput="filterTable(0)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" id="filterCaratula" placeholder="Filtrar por Carátula" oninput="filterTable(1)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" id="filterCliente" placeholder="Filtrar por Cliente (DNI)" oninput="filterTable(2)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" id="filterJuzgado" placeholder="Filtrar por Juzgado" oninput="filterTable(3)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" id="filterObjeto" placeholder="Filtrar por Objeto" oninput="filterTable(4)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <thead>
            <tr>
                <th>Número de Expediente</th>
                <th>Carátula</th>
                <th>Cliente (DNI)</th>
                <th>Juzgado</th>
                <th>Objeto</th>
                <th>Fecha de Alta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT Numero_Expediente, Clientes.DNI AS ClienteDNI, Clientes.Nombre AS ClienteNombre, 
                           Juzgados.Nombre AS Juzgado, Objeto.Descripcion AS Objeto, 
                           Causas.Descripcion AS Caratula, Fecha_Alta
                    FROM Causas
                    LEFT JOIN Clientes ON Causas.Cliente_DNI = Clientes.DNI
                    LEFT JOIN Juzgados ON Causas.Juzgado_ID = Juzgados.ID
                    LEFT JOIN Objeto ON Causas.Objeto_ID = Objeto.ID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Numero_Expediente']}</td>";
                    echo "<td>{$row['Caratula']}</td>";
                    echo "<td>{$row['ClienteNombre']} - {$row['ClienteDNI']}</td>";
                    echo "<td>{$row['Juzgado']}</td>";
                    echo "<td>{$row['Objeto']}</td>";
                    echo "<td>{$row['Fecha_Alta']}</td>";
                    echo "<td class=\"action-buttons\">
                            <a class=\"edit\" href=\"editar_causa.php?numero_expediente={$row['Numero_Expediente']}\"><i class=\"fas fa-edit\"></i> Editar</a>
                            <a class=\"delete\" href=\"eliminar_causa.php?numero_expediente={$row['Numero_Expediente']}\" onclick=\"return confirm('¿Estás seguro de eliminar esta causa?');\"><i class=\"fas fa-trash-alt\"></i> Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay causas registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function filterTable(columnIndex) {
        const inputs = document.querySelectorAll('.filter-container input');
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let visible = true;
            inputs.forEach((input, index) => {
                const cell = row.cells[index];
                if (cell && input.value) {
                    const text = cell.textContent.toLowerCase();
                    const search = input.value.toLowerCase();
                    if (!text.includes(search)) {
                        visible = false;
                    }
                }
            });
            row.style.display = visible ? '' : 'none';
        });
    }
    </script>

    <script>
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
    </script>

    <?php
    // Procesar formulario de agregar causa
    if (isset($_POST['agregar'])) {
        $numero_expediente = $_POST['numero_expediente'];
        $cliente_dni = $_POST['cliente_dni'];
        $juzgado_id = $_POST['juzgado_id'];
        $objeto_id = $_POST['objeto_id'];
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha_alta = $conn->real_escape_string($_POST['fecha_alta']);

        $sql = "INSERT INTO Causas (Numero_Expediente, Cliente_DNI, Juzgado_ID, Objeto_ID, Descripcion, Fecha_Alta) 
                VALUES ('$numero_expediente', '$cliente_dni', '$juzgado_id', '$objeto_id', '$descripcion', '$fecha_alta')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Causa agregada con éxito.</p>";
            if (!headers_sent()) {
                header("Refresh:0");
                ob_end_flush();
            } else {
                echo "<p>Los encabezados ya fueron enviados. Por favor, recarga la página manualmente.</p>";
            }
        } else {
            echo "<p>Error al agregar causa: " . $conn->error . "</p>";
            echo "<p>Consulta ejecutada: $sql</p>";
        }
    }
    ?>
</body>

</html>