<?php
// database/conexion.php

$host = 'localhost';
$user = 'root';
$password = ''; // Cambiar si tiene contraseña
$dbname = 'proyecto_abogados';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
