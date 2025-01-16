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
            <input type="text" id="cliente_dni_search" placeholder="Buscar cliente..."
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <select id="cliente_dni" name="cliente_dni" required style="margin-top: 10px; width: 100%;">
                <option value="">Seleccione un cliente</option>
                <?php
                $clientes = $conn->query("SELECT Nombre, DNI FROM Clientes");
                while ($cliente = $clientes->fetch_assoc()) {
                    echo "<option value='{{$cliente['Nombre'] - $cliente['DNI']}'> DNI: {$cliente['DNI']}}</option>";
                }
                ?>
                <option value="add">+ Agregar Nuevo Cliente</option>
            </select>

            <script>
            const searchInput = document.getElementById('cliente_dni_search');
            const selectElement = document.getElementById('cliente_dni');

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                for (const option of selectElement.options) {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) || option.value === "" ? "block" : "none";
                }
            });

            selectElement.addEventListener('change', function() {
                if (selectElement.value === 'add') {
                    openClientePopup();
                }
            });

            function openClientePopup() {
                const popup = document.createElement('div');
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.backgroundColor = 'white';
                popup.style.padding = '20px';
                popup.style.borderRadius = '10px';
                popup.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                popup.style.zIndex = '1000';
                popup.innerHTML = `
                            <form action="clientes.php" method="POST">
                            <label for="nuevo_dni">DNI:</label>
                            <input type="text" id="nuevo_dni" name="dni" required>
                            <label for="nuevo_nombre">Nombre:</label>
                            <input type="text" id="nuevo_nombre" name="nombre" required>
                            <label for="nuevo_contacto">Contacto:</label>
                            <input type="text" id="nuevo_contacto" name="contacto">
                            <label for="nuevo_otros">Otros Datos:</label>
                            <textarea id="nuevo_otros" name="otros_datos"></textarea>
                            <button type="submit">Guardar</button>
                            <button type="button" onclick="document.body.removeChild(this.parentNode)">Cerrar</button>
                        </form>
                    `;
                document.body.appendChild(popup);
            }
            </script>
            <button type="button" onclick="openClientePopup()"
                style="margin-top: 10px; background-color: #007BFF; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">+
                Agregar Nuevo Cliente</button>

            <script>
            document.getElementById('cliente_dni').addEventListener('change', function() {
                if (this.value === 'add') {
                    openClientePopup();
                }
            });

            function openClientePopup() {
                const popup = document.createElement('div');
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.backgroundColor = 'white';
                popup.style.padding = '20px';
                popup.style.borderRadius = '10px';
                popup.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                popup.style.zIndex = '1000';
                popup.innerHTML = `
                        <h2>Agregar Nuevo Cliente</h2>
                        <form action="clientes.php" method="POST">
                            <label for="nuevo_dni">DNI:</label>
                            <input type="text" id="nuevo_dni" name="dni" required>
                            <label for="nuevo_nombre">Nombre:</label>
                            <input type="text" id="nuevo_nombre" name="nombre" required>
                            <label for="nuevo_contacto">Contacto:</label>
                            <input type="text" id="nuevo_contacto" name="contacto">
                            <label for="nuevo_otros">Otros Datos:</label>
                            <textarea id="nuevo_otros" name="otros_datos"></textarea>
                            <button type="submit">Guardar</button>
                            <button type="button" onclick="document.body.removeChild(this.parentNode)">Cerrar</button>
                        </form>
                    `;
                document.body.appendChild(popup);
            }
            </script>

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
        <div class="filter-container"
            style="background-color: #007BFF; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; gap: 10px; margin-bottom: 15px;">
            <input type="text" id="filterNumero" placeholder="Filtrar por Número de Expediente" oninput="filterTable(0)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <input type="text" id="filterCaratula" placeholder="Filtrar por Carátula" oninput="filterTable(1)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <input type="text" id="filterCliente" placeholder="Filtrar por Cliente (DNI)" oninput="filterTable(2)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <input type="text" id="filterJuzgado" placeholder="Filtrar por Juzgado" oninput="filterTable(3)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <input type="text" id="filterObjeto" placeholder="Filtrar por Objeto" oninput="filterTable(4)"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
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
        <?php
        // Paginación
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $sql_count = "SELECT COUNT(*) AS total FROM Causas";
        $result_count = $conn->query($sql_count);
        $total_rows = $result_count->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);

        $sql = "SELECT Numero_Expediente, Clientes.DNI AS ClienteDNI, Clientes.Nombre AS ClienteNombre, 
                           Juzgados.Nombre AS Juzgado, Objeto.Descripcion AS Objeto, 
                           Causas.Descripcion AS Caratula, Fecha_Alta
                    FROM Causas
                    LEFT JOIN Clientes ON Causas.Cliente_DNI = Clientes.DNI
                    LEFT JOIN Juzgados ON Causas.Juzgado_ID = Juzgados.ID
                    LEFT JOIN Objeto ON Causas.Objeto_ID = Objeto.ID
                    LIMIT $limit OFFSET $offset";
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

    <!-- Paginación -->
    <div class="pagination"
        style="text-align: center; margin-top: 20px; display: flex; justify-content: center; align-items: center; gap: 5px;">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = $i == $page ? 'background-color: #007BFF; color: white;' : 'background-color: #f9f9f9; color: #007BFF;';
            echo "<a href='causas.php?page=$i' style='padding: 8px 12px; margin: 0 5px; border: 1px solid #ddd; text-decoration: none; border-radius: 5px; $active'>$i</a>";
        }
        ?>
    </div>
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