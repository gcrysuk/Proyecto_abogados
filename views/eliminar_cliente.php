<?php
// views/eliminar_cliente.php
include_once '../database/conexion.php';

// Obtener el ID del cliente
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de cliente no proporcionado.");
}

// Eliminar cliente
$sql = "DELETE FROM Clientes WHERE ID = $id";
if ($conn->query($sql) === TRUE) {
    echo "<p>Cliente eliminado con éxito.</p>";
    header("Location: clientes.php"); // Redirigir a la lista de clientes
    exit;
} else {
    echo "<p>Error al eliminar cliente: " . $conn->error . "</p>";
}
?>
