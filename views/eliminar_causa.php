<?php
// views/eliminar_causa.php
include_once '../database/conexion.php';

// Obtener el número de expediente
$numero_expediente = $_GET['numero_expediente'] ?? null;

if (!$numero_expediente) {
    die("Número de expediente no proporcionado.");
}

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conn->prepare("DELETE FROM Causas WHERE Numero_Expediente = ?");
$stmt->bind_param("s", $numero_expediente);

if ($stmt->execute()) {
    echo "<p>Causa eliminada con éxito.</p>";
    header("Location: causas.php"); // Redirigir a la lista de causas
    exit;
} else {
    echo "<p>Error al eliminar causa: " . $conn->error . "</p>";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
