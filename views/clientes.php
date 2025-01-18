<?php
// views/clientes.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    
    <style>
        /* Ancho personalizado de las columnas */
        table th:nth-child(1), table td:nth-child(1) { width: 14%; } /* Nombre */
        table th:nth-child(2), table td:nth-child(2) { width: 10%; } /* DNI */
        table th:nth-child(3), table td:nth-child(3) { width: 12%; } /* Contacto */
        table th:nth-child(4), table td:nth-child(4) { width: 18%; } /* Otros Datos */
        table th:nth-child(5), table td:nth-child(5) { width: 13%; } /* Acciones */

    </style>
</head>

<?php
// Procesar formulario de agregar cliente
if (isset($_POST['agregar'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $otros_datos = $_POST['otros_datos'];

    $sql = "INSERT INTO Clientes (DNI, Nombre, Contacto, Otros_Datos) VALUES ('$dni', '$nombre', '$contacto', '$otros_datos')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Cliente agregado con éxito.</p>";
        header("Refresh:0"); // Recargar la página
    } else {
        echo "<p>Error al agregar cliente: " . $conn->error . "</p>";
    }
}
?>
<?php
// views/clientes.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0 1cm;
            /* Márgenes laterales */
        }

        
    </style>
</head>

<body>
    <a href="../index.php"
        style="display: inline-block; margin-bottom: 20px; background-color: #007BFF; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;"><i
            class='fas fa-home'></i> Inicio</a>
    <header>Gestión de Clientes</header>

    <!-- Botón para abrir el formulario en un popup -->
    <div class="add-client-btn" onclick="openPopup()">
        <i class="fas fa-user-plus"></i> Agregar Cliente
    </div>

    <!-- Popup para agregar cliente -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
        <div class="popup-header">Agregar Cliente</div>
        <form action="clientes.php" method="POST">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="contacto">Contacto:</label>
            <input type="text" id="contacto" name="contacto">

            <label for="otros_datos">Otros Datos:</label>
            <textarea id="otros_datos" name="otros_datos"></textarea>

            <button type="submit" name="agregar">Agregar Cliente</button>
            <button type="button" onclick="closePopup()">Cancelar</button>
        </form>
    </div>

    <hr>

    <!-- Filtros para la tabla -->
    <div class="filter-container">
        <input type="text" id="filterNombre" placeholder="Filtrar por Nombre" oninput="filterTable(0)">
        <input type="text" id="filterDNI" placeholder="Filtrar por DNI" oninput="filterTable(1)">
        <input type="text" id="filterContacto" placeholder="Filtrar por Contacto" oninput="filterTable(2)">
        <input type="text" id="filterOtrosDatos" placeholder="Filtrar por Otros Datos" oninput="filterTable(3)">
    </div>

    <table id="clientesTable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Contacto</th>
                <th>Otros Datos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Configuración de paginación
            $limit = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Consultar clientes ordenados por nombre con paginación
            $sql = "SELECT * FROM Clientes ORDER BY Nombre ASC LIMIT $limit OFFSET $offset";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Nombre']}</td>";
                    echo "<td>{$row['DNI']}</td>";
                    echo "<td>{$row['Contacto']}</td>";
                    echo "<td>{$row['Otros_Datos']}</td>";
                    echo "<td class='action-buttons'>
                            <a class='edit' href='editar_cliente.php?dni={$row['DNI']}'>
                                <i class='fas fa-edit'></i> Editar
                            </a>
                            <a class=\"btn delete\" href=\"eliminar_cliente.php?dni={$row['DNI']}\" 
                                onclick=\"return confirm('¿Estás seguro de eliminar este cliente?');\">
                                <i class=\"fas fa-trash-alt\"></i> Eliminar
                            </a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay clientes registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <?php
        $result_total = $conn->query("SELECT COUNT(*) AS total FROM Clientes");
        $total_rows = $result_total->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);

        for ($i = 1; $i <= $total_pages; $i++) {
            $active = $i == $page ? 'active' : '';
            echo "<button class='$active' onclick=\"window.location='clientes.php?page=$i'\">$i</button>";
        }
        ?>
    </div>

    <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function filterTable(columnIndex) {
            const inputs = document.querySelectorAll('.filter-container input');
            const table = document.getElementById('clientesTable');
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

    <?php
    // Procesar formulario de agregar cliente
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $contacto = $_POST['contacto'];
        $otros_datos = $_POST['otros_datos'];

        $sql = "INSERT INTO Clientes (Nombre, DNI, Contacto, Otros_Datos) VALUES ('$nombre', '$dni', '$contacto', '$otros_datos')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Cliente agregado con éxito.</p>";
            header("Refresh:0"); // Recargar la página
        } else {
            echo "<p>Error al agregar cliente: " . $conn->error . "</p>";
        }
    }
    ?>
</body>

</html>
</body>

</html>