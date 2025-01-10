<?php
// views/editar_cliente.php
include_once '../database/conexion.php';

// Obtener el DNI del cliente
$dni = $_GET['dni'] ?? null;
if (!$dni) {
    die("DNI de cliente no proporcionado.");
}

// Consultar datos del cliente
$sql = "SELECT * FROM Clientes WHERE DNI = '$dni'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Cliente no encontrado.");
}

$cliente = $result->fetch_assoc();

// Procesar formulario de actualización
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $otros_datos = $_POST['otros_datos'];

    $sql = "UPDATE Clientes SET Nombre = '$nombre', Contacto = '$contacto', Otros_Datos = '$otros_datos' WHERE DNI = '$dni'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Cliente actualizado con éxito.</p>";
        header("Location: clientes.php"); // Redirigir a la lista de clientes
        exit;
    } else {
        echo "<p>Error al actualizar cliente: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Editar Cliente</h1>

    <form action="" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" value="<?php echo $cliente['DNI']; ?>" disabled>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['Nombre']; ?>" required>

        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto" value="<?php echo $cliente['Contacto']; ?>">

        <label for="otros_datos">Otros Datos:</label>
        <textarea id="otros_datos" name="otros_datos"><?php echo $cliente['Otros_Datos']; ?></textarea>

        <button type="submit" name="actualizar">Actualizar Cliente</button>
    </form>

    <a href="clientes.php">Volver a la lista de clientes</a>
</body>
</html>
