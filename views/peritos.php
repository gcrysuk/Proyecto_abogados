<?php
// views/peritos.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Peritos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Gestión de Peritos</h1>

    <?php
    // Obtener la página de regreso
    $return_page = isset($_GET['return']) ? $_GET['return'] : 'peritos.php';
    ?>

    <!-- Formulario para agregar un perito -->
    <form action="peritos.php?return=<?php echo htmlspecialchars($return_page); ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="especialidad">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad" required>

        <button type="submit" name="agregar">Agregar Perito</button>
    </form>

    <hr>

    <!-- Lista de peritos -->
    <h2>Lista de Peritos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar peritos
            $sql = "SELECT * FROM Peritos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>" . htmlspecialchars($row['Nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Especialidad']) . "</td>";
                    echo "<td>
                            <a href='editar_perito.php?id={$row['ID']}'>Editar</a>
                            <a href='eliminar_perito.php?id={$row['ID']}' onclick='return confirm(\"¿Estás seguro de eliminar este perito?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay peritos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Procesar formulario de agregar perito
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $especialidad = $_POST['especialidad'];

        $sql = "INSERT INTO Peritos (Nombre, Especialidad) VALUES ('$nombre', '$especialidad')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Perito agregado con éxito.</p>";
            header("Location: " . htmlspecialchars($return_page));
            exit;
        } else {
            echo "<p>Error al agregar perito: " . $conn->error . "</p>";
        }
    }
    ?>

    <a href="<?php echo htmlspecialchars($return_page); ?>">Volver</a>
</body>
</html>
