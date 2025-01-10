<?php
// views/eliminar_causa.php
include_once '../database/conexion.php';

// Obtener el ID de la causa
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de causa no proporcionado.");
}

// Eliminar causa
$sql = "DELETE FROM Causas WHERE ID = $id";
if ($conn->query($sql) === TRUE) {
    echo "<p>Causa eliminada con éxito.</p>";
    header("Location: causas.php"); // Redirigir a la lista de causas
    exit;
} else {
    echo "<p>Error al eliminar causa: " . $conn->error . "</p>";
}
?>
