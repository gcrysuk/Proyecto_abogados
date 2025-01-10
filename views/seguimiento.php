<?php
// views/seguimiento.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Causas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Seguimiento de Causas</h1>

    <!-- Formulario para registrar un paso procesal -->
    <form action="seguimiento.php" method="POST">
        <label for="causa_id">Causa (Expediente):</label>
        <select id="causa_id" name="causa_id" required>
            <?php
            $causas = $conn->query("SELECT ID, Numero_Expediente FROM Causas");
            while ($causa = $causas->fetch_assoc()) {
                echo "<option value='{$causa['ID']}'>Expediente: {$causa['Numero_Expediente']}</option>";
            }
            ?>
        </select>

        <label for="detalle">Detalle del Paso Procesal:</label>
        <textarea id="detalle" name="detalle" required></textarea>

        <label for="estado_id">Estado:</label>
        <select id="estado_id" name="estado_id" required>
            <?php
            $estados = $conn->query("SELECT ID, Descripcion FROM Estados");
            while ($estado = $estados->fetch_assoc()) {
                echo "<option value='{$estado['ID']}'>{$estado['Descripcion']}</option>";
            }
            ?>
        </select>

        <label for="fecha_movimiento">Fecha de Movimiento:</label>
        <input type="date" id="fecha_movimiento" name="fecha_movimiento" required>

        <button type="submit" name="registrar">Registrar Paso</button>
    </form>

    <hr>

    <!-- Lista de pasos procesales -->
    <h2>Pasos Procesales Registrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Causa (Expediente)</th>
                <th>Detalle</th>
                <th>Estado</th>
                <th>Fecha de Movimiento</th>
                <th>Fecha y Hora de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT Seguimiento.ID, Causas.Numero_Expediente AS Causa, Seguimiento.Detalle, Estados.Descripcion AS Estado,
                           Seguimiento.Fecha_Movimiento, Seguimiento.Timestamp
                    FROM Seguimiento
                    LEFT JOIN Causas ON Seguimiento.Causa_ID = Causas.ID
                    LEFT JOIN Estados ON Seguimiento.Estado_ID = Estados.ID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['Causa']}</td>";
                    echo "<td>{$row['Detalle']}</td>";
                    echo "<td>{$row['Estado']}</td>";
                    echo "<td>{$row['Fecha_Movimiento']}</td>";
                    echo "<td>{$row['Timestamp']}</td>";
                    echo "<td>
                            <a href='editar_seguimiento.php?id={$row['ID']}'>Editar</a>
                            <a href='eliminar_seguimiento.php?id={$row['ID']}' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay pasos procesales registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Procesar formulario de registro
    if (isset($_POST['registrar'])) {
        $causa_id = $_POST['causa_id'];
        $detalle = $_POST['detalle'];
        $estado_id = $_POST['estado_id'];
        $fecha_movimiento = $_POST['fecha_movimiento'];

        $sql = "INSERT INTO Seguimiento (Causa_ID, Detalle, Estado_ID, Fecha_Movimiento) 
                VALUES ('$causa_id', '$detalle', '$estado_id', '$fecha_movimiento')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Paso procesal registrado con éxito.</p>";
            header("Refresh:0"); // Recargar la página
        } else {
            echo "<p>Error al registrar paso procesal: " . $conn->error . "</p>";
        }
    }
    ?>
</body>
</html>
