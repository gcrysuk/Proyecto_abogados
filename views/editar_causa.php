<?php
// views/editar_Causa.php
include_once '../database/conexion.php';

// Obtener el Número de Expediente
$numero_expediente = $_GET['numero_expediente'] ?? null;
if (!$numero_expediente) {
    die("Número de Expediente no proporcionado.");
}

// Consultar datos de la causa
$sql = "SELECT * FROM causas WHERE Numero_Expediente = '$numero_expediente'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Expediente no encontrado.");
}

$cliente = $result->fetch_assoc();

// Procesar formulario de actualización
if (isset($_POST['actualizar'])) {
    $cliente_dni = $_POST['cliente_dni'];
    $juzgado_id = $_POST['juzgado_id'];
    $objeto_id = $_POST['objeto_id'];
    $descripcion = $_POST['descripcion'];
    $fecha_alta = $_POST['fecha_alta'];

    $sql = "UPDATE causas SET 
                cliente_dni = '$cliente_dni', 
                juzgado_id = '$juzgado_id', 
                objeto_id = '$objeto_id', 
                descripcion = '$descripcion', 
                fecha_alta = '$fecha_alta' 
            WHERE Numero_Expediente = '$numero_expediente'";

    if ($conn->query($sql) === TRUE) {
        header("Location: causas.php");
        exit;
    } else {
        echo "<p>Error al actualizar causa: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Causa</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Editar Causa</h1>

    <form action="" method="POST">
        <label for="numero_expediente">Expediente:</label>
        <input type="text" id="numero_expediente" value="<?php echo $causas['Numero_Expediente']; ?>" disabled>

        <label for="cliente_dni">Cliente:</label>
        <input type="text" id="cliente_dni" name="cliente_dni" value="<?php echo $causas['cliente_dni']; ?>" required>

        <label for="juzgado_id">Juzgado:</label>
        <input type="text" id="juzgado_id" name="juzgado_id" value="<?php echo $causas['juzgado_id']; ?>">

        <label for="objeto_id">Objeto:</label>
        <input type="text" id="objeto_id" name="objeto_id" value="<?php echo $causas['objeto_id']; ?>">

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"><?php echo $cliente['descripcion']; ?></textarea>

        <label for="fecha_alta">Fecha de Alta:</label>
        <input type="date" id="fecha_alta" name="fecha_alta" value="<?php echo $causas['fecha_alta']; ?>">

        <button type="submit" name="actualizar">Actualizar Causa</button>
    </form>

    <a href="causas.php">Volver a la lista de causas</a>
</body>
</html>
