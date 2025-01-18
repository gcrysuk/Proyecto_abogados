<?php
// views/eliminar_cliente.php
include_once '../database/conexion.php';

// Obtener el ID del cliente
$dni = $_GET['dni'] ?? null;

if (!$dni) {
    die("DNI de cliente no proporcionado.");
}

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conn->prepare("DELETE FROM Clientes WHERE DNI = ?");
$stmt->bind_param("s", $dni);

if ($stmt->execute()) {
    echo "<p>Cliente eliminado con éxito.</p>";
    header("Location: clientes.php"); // Redirigir a la lista de causas
    exit;
} else {
    echo "<p>Error al eliminar causa: " . $conn->error . "</p>";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>