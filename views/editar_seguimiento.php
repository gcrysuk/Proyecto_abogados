<?php
// views/editar_seguimientos.php
include_once '../database/conexion.php';

// Obtener el ID del seguimiento
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de seguimiento no proporcionado.");
}

// Consultar datos del seguimiento
$sql = "SELECT * FROM Seguimiento WHERE ID = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Registro de seguimiento no encontrado.");
}

$seguimiento = $result->fetch_assoc();

// Procesar formulario de actualización
if (isset($_POST['actualizar'])) {
    $causa_id = $_POST['causa_id'];
    $detalle = $_POST['detalle'];
    $estado_id = $_POST['estado_id'];
    $fecha_movimiento = $_POST['fecha_movimiento'];

    $sql = "UPDATE Seguimiento SET Causa_ID = '$causa_id', Detalle = '$detalle', Estado_ID = '$estado_id', 
            Fecha_Movimiento = '$fecha_movimiento' WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Registro actualizado con éxito.</p>";
        header("Location: seguimientos.php"); // Redirigir a la lista de seguimientos
        exit;
    } else {
        echo "<p>Error al actualizar el registro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Seguimiento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Editar Seguimiento</h1>

    <form action="" method="POST">
        <label for="causa_id">Causa (Expediente):</label>
        <select id="causa_id" name="causa_id" required>
            <?php
            $causas = $conn->query("SELECT ID, Numero_Expediente FROM Causas");
            while ($causa = $causas->fetch_assoc()) {
                $selected = $causa['ID'] == $seguimiento['Causa_ID'] ? 'selected' : '';
                echo "<option value='{$causa['ID']}' $selected>Expediente: {$causa['Numero_Expediente']}</option>";
            }
            ?>
        </select>

        <label for="detalle">Detalle del Paso Procesal:</label>
        <textarea id="detalle" name="detalle" required><?php echo $seguimiento['Detalle']; ?></textarea>

        <label for="estado_id">Estado:</label>
        <select id="estado_id" name="estado_id" required>
            <?php
            $estados = $conn->query("SELECT ID, Descripcion FROM Estados");
            while ($estado = $estados->fetch_assoc()) {
                $selected = $estado['ID'] == $seguimiento['Estado_ID'] ? 'selected' : '';
                echo "<option value='{$estado['ID']}' $selected>{$estado['Descripcion']}</option>";
            }
            ?>
        </select>

        <label for="fecha_movimiento">Fecha de Movimiento:</label>
        <input type="date" id="fecha_movimiento" name="fecha_movimiento" value="<?php echo $seguimiento['Fecha_Movimiento']; ?>" required>

        <button type="submit" name="actualizar">Actualizar Seguimiento</button>
    </form>

    <a href="seguimientos.php">Volver a la lista de seguimientos</a>
</body>
</html>
