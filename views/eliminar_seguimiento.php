<?php
// views/eliminar_seguimientos.php
include_once '../database/conexion.php';

// Obtener el ID del seguimiento
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de seguimiento no proporcionado.");
}

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conn->prepare("DELETE FROM seguimiento WHERE ID = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo "<p>Cliente eliminado con éxito.</p>";
    header("Location: seguimientos.php"); // Redirigir a la lista de causas
    exit;
} else {
    echo "<p>Error al eliminar causa: " . $conn->error . "</p>";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>