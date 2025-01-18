<?php
ob_start();
// views/causas.php
require_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Causas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Ancho personalizado de las columnas */
        table th:nth-child(1), table td:nth-child(1) { width: 10%; } /* Número de Expediente */
        table th:nth-child(2), table td:nth-child(2) { width: 22%; } /* Carátula */
        table th:nth-child(3), table td:nth-child(3) { width: 12%; } /* Cliente (DNI) */
        table th:nth-child(4), table td:nth-child(4) { width: 15%; } /* Juzgado */
        table th:nth-child(5), table td:nth-child(5) { width: 5%; } /* Objeto */
        table th:nth-child(6), table td:nth-child(6) { width: 6%; } /* Fecha de Alta */
        table th:nth-child(7), table td:nth-child(7) { width: 13%; } /* Acciones */
    </style>

</head>
<body>
    <a href="../index.php"
        style="display: inline-block; margin-bottom: 20px; background-color: #007BFF; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;"><i
            class='fas fa-home'></i> Inicio</a>
    <header>Gestión de Causas</header>
    <script src="/Proyecto_abogados/js/funciones.js"></script>
    <script src="/Proyecto_abogados/js/scripts.js"></script>
    <script src="/Proyecto_abogados/js/popup.js"></script>
    <script src="/Proyecto_abogados/js/datalist.js"></script>
    
            
   <!-- Botón para abrir el formulario en un popup -->
    <div class="add-causa-btn" onclick="openPopup('popup1', 'overlay1')">
        <i class="fas fa-folder-plus"></i> Agregar Causa
    </div>
    <!-- Overlay y Primer Popup -->
    <div class="overlay" id="overlay1" onclick="closePopup('popup1', 'overlay1')"></div>
    <div class="popup" id="popup1">
        <div class="popup-header" >            
            <h2>Agregar Causa</h2>
            <button type="button" onclick="closePopup('popup1', 'overlay1')" aria-label="Cerrar">&times;</button>
        </div>
        <div class="form-container">
            <form action="causas.php" method="POST">
                <label for="numero_expediente">Número de Expediente:</label>
                <input type="text" id="numero_expediente" name="numero_expediente" required>
                <label for="descripcion">Carátula:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
                <!-- Campo visible para buscar clientes -->
                <label for="cliente_dni_search">Cliente (DNI):</label>
                <input 
                    list="clientes_datalist" 
                    id="cliente_dni_search" 
                    name="cliente_nombre" 
                    placeholder="Buscar cliente..." 
                    required
                    >
                <!-- Datalist con nombres y DNIs -->
                <datalist id="clientes_datalist">
                    <?php
                        $clientes = $conn->query("SELECT DNI, Nombre FROM Clientes ORDER BY Nombre ASC");
                        while ($cliente = $clientes->fetch_assoc()) {
                            // Mostrar el nombre al usuario pero usar el DNI como referencia
                            echo "<option value='{$cliente['DNI']}' data-dni='{$cliente['DNI']}'>{$cliente['Nombre']}</option>";
                        }
                    ?>
                </datalist>
                <!-- Campo oculto para almacenar el DNI seleccionado -->
                <input type="hidden" id="cliente_dni" name="cliente_dni">
                <script>
                    const searchInput = document.getElementById('cliente_dni_search');
                    const hiddenDniInput = document.getElementById('cliente_dni');
                    const datalist = document.getElementById('clientes_datalist');
                    // Detectar cuando se selecciona un valor del datalist
                    searchInput.addEventListener('input', () => {
                        const selectedOption = Array.from(datalist.options).find(option => option.value === searchInput.value);
                    
                        if (selectedOption) {
                            // Extraer el DNI del atributo data-dni y asignarlo al campo oculto
                            hiddenDniInput.value = selectedOption.getAttribute('data-dni');
                        } else {
                            // Si no hay coincidencia, limpiar el campo oculto
                            hiddenDniInput.value = '';
                        }
                        });
                </script>
                <label for="juzgado_id">Juzgado:</label>
                <select id="juzgado_id" name="juzgado_id">
                <?php
                    $juzgados = $conn->query("SELECT ID, Nombre FROM Juzgados order by nombre asc");
                    while ($juzgado = $juzgados->fetch_assoc()) {
                        echo "<option value='{$juzgado['ID']}'>{$juzgado['Nombre']}</option>";
                    }
                ?>
                </select>
                <label for="objeto_id">Objeto:</label>
                <select id="objeto_id" name="objeto_id">
                    <?php
                    $objetos = $conn->query("SELECT ID, Descripcion FROM Objeto");
                    while ($objeto = $objetos->fetch_assoc()) {
                        echo "<option value='{$objeto['ID']}'>{$objeto['Descripcion']}</option>";
                    }
                    ?>
                </select>
                <label for="fecha_alta">Fecha de Alta:</label>
                <input type="date" id="fecha_alta" name="fecha_alta" required>
                    <button type="submit" name="agregar" class="btn-submit">Agregar</button>
                    <button type="button" class="btn-secondary" onclick="closePopup('popup1', 'overlay1')">Cancelar</button>
                    <button type="button" class="btn-secondary" onclick="openPopup('popup2', 'overlay2')">Nuevo Cliente</button>
            </form>
        </div>
    </div>
    <!-- Overlay y Segundo Popup -->
    <div class="overlay" id="overlay2" onclick="closePopup('popup2', 'overlay2')"></div>
    <div class="popup" id="popup2">
        <div class="popup-header">
            <h2>Agregar Nuevo Cliente</h2>
            <button type="button" onclick="closePopup('popup2', 'overlay2')" aria-label="Cerrar">&times;</button>
        </div>
        <form action="clientes.php" method="POST">
            <label for="nuevo_dni">DNI:</label>
            <input type="text" id="nuevo_dni" name="dni" required>

            <label for="nuevo_nombre">Nombre:</label>
            <input type="text" id="nuevo_nombre" name="nombre" required>

            <label for="nuevo_contacto">Contacto:</label>
            <input type="text" id="nuevo_contacto" name="contacto">

            <label for="nuevo_otros">Otros Datos:</label>
            <textarea id="nuevo_otros" name="otros_datos"></textarea>

            <div style="margin-top: 10px;">
                <button type="submit" name="agregar" class="btn-submit">Agregar Cliente</button>
                <button type="button" class="btn-secondary" onclick="closePopup('popup2', 'overlay2')">Cerrar</button>
            </div>
        </form>
    </div>

    <hr>

    <!-- Lista de causas -->
    
    <table id="clientesTable">
        <div class="filter-container">
            <input type="text" id="filterNumero" placeholder="Filtrar por Número de Expediente" oninput="filterTable(0)">
            <input type="text" id="filterCaratula" placeholder="Filtrar por Carátula" oninput="filterTable(1)">
            <input type="text" id="filterCliente" placeholder="Filtrar por Cliente (DNI)" oninput="filterTable(2)">
            <input type="text" id="filterJuzgado" placeholder="Filtrar por Juzgado" oninput="filterTable(3)">
            <input type="text" id="filterObjeto" placeholder="Filtrar por Objeto" oninput="filterTable(4)">
                
        </div>
        <thead>
            <tr>
                <th>Número de Expediente</th>
                <th>Carátula</th>
                <th>Cliente (DNI)</th>
                <th>Juzgado</th>
                <th>Objeto</th>
                <th>Inicio</th>
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
                    ORDER BY Causas.Descripcion ASC
                    LIMIT $limit OFFSET $offset" ;
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
                            <a class=\"btn edit\" href=\"editar_causa.php?numero_expediente={$row['Numero_Expediente']}\">
                                <i class=\"fas fa-edit\"></i> Editar
                            </a>
                            <a class=\"btn delete\" href=\"eliminar_causa.php?numero_expediente={$row['Numero_Expediente']}\" 
                            onclick=\"return confirm('¿Estás seguro de eliminar esta causa?');\">
                                <i class=\"fas fa-trash-alt\"></i> Eliminar
                            </a>
                        </td>";
                echo "</tr>";
                
            }
        } else {
            echo "<tr><td colspan='7'>No hay causas registradas.</td></tr>";
        }
        ?>
        <?php
echo "<a class='btn delete' href='eliminar_causa.php?numero_expediente={$row['Numero_Expediente']}' onclick=\"return confirm('¿Estás seguro de eliminar esta causa?');\">Eliminar</a>";
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


    <?php
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $cliente_dni = $_POST['cliente_dni'];
    $numero_expediente = $_POST['numero_expediente'];
    $juzgado_id = $_POST['juzgado_id'];
    $objeto_id = $_POST['objeto_id'];
    $descripcion = $_POST['descripcion'];
    $fecha_alta = $_POST['fecha_alta'];

    // Validar que el DNI exista en la tabla Clientes
    $checkDni = $conn->query("SELECT DNI FROM Clientes WHERE DNI = '$cliente_dni'");
    if ($checkDni->num_rows === 0) {
        echo "<p>Error: El DNI $cliente_dni no existe en la tabla Clientes. Por favor, verifica tu selección.</p>";
        exit;
    }

    // Realizar la inserción
    $sql = "INSERT INTO Causas (Numero_Expediente, Cliente_DNI, Juzgado_ID, Objeto_ID, Descripcion, Fecha_Alta) 
            VALUES ('$numero_expediente', '$cliente_dni', '$juzgado_id', '$objeto_id', '$descripcion', '$fecha_alta')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Causa agregada con éxito.</p>";
        header("Refresh:0"); // Recargar la página
        ob_end_flush();
    } else {
        echo "<p>Error al agregar causa: " . $conn->error . "</p>";
        echo "<p>Consulta ejecutada: $sql</p>";
    }
}
?>
   
</body>
</html>