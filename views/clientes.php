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
</head>
<body>
    <h1>Gestión de Clientes</h1>

    <?php
    // Obtener la página de regreso
    $return_page = isset($_GET['return']) ? $_GET['return'] : 'clientes.php';
    ?>

    <!-- Formulario para agregar un cliente -->
    <form action="clientes.php?return=<?php echo htmlspecialchars($return_page); ?>" method="POST">
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

    <!-- Lista de clientes -->
    <h2>Lista de Clientes</h2>
    <table border="1">
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
                    echo "<td>
                            <a href='editar_cliente.php?dni={$row['DNI']}'>Editar</a>
                            <a href='eliminar_cliente.php?dni={$row['DNI']}' onclick='return confirm(\"¿Estás seguro de eliminar este cliente?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay clientes registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

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
            header("Location: " . htmlspecialchars($return_page));
            exit;
        } else {
            echo "<p>Error al agregar cliente: " . $conn->error . "</p>";
        }
    }
    ?>

    <a href="<?php echo htmlspecialchars($return_page); ?>">Volver</a>
</body>
</html>
