<?php
// views/eliminar_seguimientos.php
include_once '../database/conexion.php';

// Obtener el ID del seguimiento
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de seguimiento no proporcionado.");
}

// Eliminar seguimiento
$sql = "DELETE FROM Seguimiento WHERE ID = $id";
if ($conn->query($sql) === TRUE) {
    echo "<p>Registro de seguimiento eliminado con éxito.</p>";
    header("Location: seguimientos.php"); // Redirigir a la lista de seguimientos
    exit;
} else {
    echo "<p>Error al eliminar el registro: " . $conn->error . "</p>";
}
?>
