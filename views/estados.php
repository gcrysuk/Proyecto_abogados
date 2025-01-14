<?php
// views/estados.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estados</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Gestión de Estados</h1>

    <?php
    // Obtener la página de regreso
    $return_page = isset($_GET['return']) ? $_GET['return'] : 'estados.php';
    ?>

    <!-- Formulario para agregar un estado -->
    <form action="estados.php?return=<?php echo htmlspecialchars($return_page); ?>" method="POST">
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>

        <button type="submit" name="agregar">Agregar Estado</button>
    </form>

    <hr>

    <!-- Lista de estados -->
    <h2>Lista de Estados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar estados
            $sql = "SELECT * FROM Estados";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>" . htmlspecialchars($row['Descripcion']) . "</td>";
                    echo "<td>
                            <a href='editar_estado.php?id={$row['ID']}'>Editar</a>
                            <a href='eliminar_estado.php?id={$row['ID']}' onclick='return confirm(\"¿Estás seguro de eliminar este estado?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay estados registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Procesar formulario de agregar estado
    if (isset($_POST['agregar'])) {
        $descripcion = $conn->real_escape_string($_POST['descripcion']);

        $sql = "INSERT INTO Estados (Descripcion) VALUES ('$descripcion')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Estado agregado con éxito.</p>";
            header("Location: " . htmlspecialchars($return_page));
            exit;
        } else {
            echo "<p>Error al agregar estado: " . $conn->error . "</p>";
        }
    }
    ?>

    <a href="<?php echo htmlspecialchars($return_page); ?>">Volver</a>
</body>
</html>
