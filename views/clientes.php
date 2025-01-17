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
            margin: 30px;
            /* Márgenes laterales */
        }

        /* Contenedor de filtros alineado con la tabla */
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007BFF;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: white;
        }

        .filter-container input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 20%;
            min-width: 150px;
        }

        .filter-container input::placeholder {
            color: #888;
        }

        /* Tabla estilizada */
        #clientesTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #clientesTable th {
            background-color: #007BFF;
            color: white;
            text-align: left;
            padding: 10px;
        }

        #clientesTable td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        #clientesTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Botones estilizados */
        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
        }

        .action-buttons .edit {
            background-color: #28a745;
        }

        .action-buttons .edit:hover {
            background-color: #218838;
        }

        .action-buttons .delete {
            background-color: #dc3545;
        }

        .action-buttons .delete:hover {
            background-color: #c82333;
        }

        /* Paginación */
        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination button {
            padding: 10px 15px;
            margin: 0 5px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button.active {
            background-color: #0056b3;
        }

        .pagination button:hover {
            background-color: #0056b3;
        }
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

        .add-client-btn {
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

        .add-client-btn i {
            margin-right: 5px;
        }

        .add-client-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <a href="../index.php"
        style="display: inline-block; margin-bottom: 20px; background-color: #007BFF; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;"><i
            class='fas fa-home'></i> Inicio</a>
    <h1>Gestión de Clientes</h1>

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
                            <a class='edit' href='editar_cliente.php?dni={$row['DNI']}'>Editar</a>
                            <a class='delete' href='eliminar_cliente.php?dni={$row['DNI']}' onclick='return confirm(\"¿Estás seguro de eliminar este cliente?\");'>Eliminar</a>
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