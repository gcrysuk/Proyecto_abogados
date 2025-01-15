<?php
// views/clientes.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
    body {
        margin: 0 1cm;
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

<body>
    <h1>Gestión de Clientes</h1>

    <!-- Formulario para agregar un cliente -->
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
    </form>

    <hr>

    <!-- Filtros para la tabla -->
    <div class="filter-container">
        <input type="text" id="filterDNI" placeholder="Filtrar por DNI" oninput="filterTable(0)">
        <input type="text" id="filterNombre" placeholder="Filtrar por Nombre" oninput="filterTable(1)">
        <input type="text" id="filterContacto" placeholder="Filtrar por Contacto" oninput="filterTable(2)">
        <input type="text" id="filterOtrosDatos" placeholder="Filtrar por Otros Datos" oninput="filterTable(3)">
    </div>

    <table id="clientesTable">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
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
                    echo "<td>{$row['DNI']}</td>";
                    echo "<td>{$row['Nombre']}</td>";
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
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $contacto = $_POST['contacto'];
        $otros_datos = $_POST['otros_datos'];

        $sql = "INSERT INTO Clientes (DNI, Nombre, Contacto, Otros_Datos) VALUES ('$dni', '$nombre', '$contacto', '$otros_datos')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Cliente agregado con éxito.</p>";
            header("Refresh:0"); // Recargar la página
        } else {
            echo "<p