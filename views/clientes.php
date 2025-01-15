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
        /* Filtros estilizados */
        .filter-container {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-container input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(25% - 10px);
            min-width: 200px;
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
    <h2>Lista de Clientes</h2>
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
            // Consultar clientes
            $sql = "SELECT * FROM Clientes";
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
            echo "<p>Error al agregar cliente: " . $conn->error . "</p>";
        }
    }
    ?>
</body>

</html>