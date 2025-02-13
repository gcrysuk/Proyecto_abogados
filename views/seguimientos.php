<?php
ob_start();
// views/seguimientos.php
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
    <div style="position: relative; display: inline-block; width: 100%;">
    <!-- Botón de inicio -->
    <a href="../index.php" 
       style="position: absolute; top: 50%; left: 50%; transform: translate(-525%, -60%); background-color:rgb(45, 136, 45); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-home"></i> Inicio
    </a>

    <!-- Título Gestión de Causas -->
    <header style="background-color: #00796b; color: white; padding: 20px; text-align: center; font-size: 28px; font-weight: 500; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        Seguimientos
    </header>
</div>
    <!-- Formulario para registrar un paso procesal -->
    <form action="seguimientos.php" method="POST">
    <label for="Numero_Expediente">Causa (Expediente):</label>
    <input 
        list="clientes_datalist" 
        id="Numero_Expediente" 
        name="Numero_Expediente" 
        placeholder="Buscar cliente..." 
        required>
    <datalist id="clientes_datalist">
        <?php
        $stmt = $conn->prepare("SELECT Causas.Numero_Expediente, Causas.Descripcion 
                        FROM Causas
                        ORDER BY Causas.Descripcion ASC");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()):
?>
    <option value="<?= htmlspecialchars($row['Numero_Expediente']) ?>">
        <?= htmlspecialchars($row['Descripcion']) ?> - <?= htmlspecialchars($row['Numero_Expediente']) ?>
    </option>
        <?php endwhile; ?>
    </datalist>

    <label for="detalle">Detalle del Paso Procesal:</label>
    <textarea id="detalle" name="detalle" required></textarea>

    <label for="estado_id">Estado:</label>
    <select id="estado_id" name="estado_id" required>
        <?php
        $stmt = $conn->prepare("SELECT ID, Descripcion FROM Estados");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($estado = $result->fetch_assoc()):
        ?>
            <option value="<?= htmlspecialchars($estado['ID']) ?>">
                <?= htmlspecialchars($estado['Descripcion']) ?>
            </option>
        <?php endwhile; ?>
        <option value="add">Agregar un nuevo estado</option>
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
                    echo "<td>" . htmlspecialchars($row['Estado']) . "</td>";
                    echo "<td>{$row['Fecha_Movimiento']}</td>";
                    echo "<td>{$row['Timestamp']}</td>";
                    echo "<td>
                            <a class=\"btn delete\" href=\"eliminar_seguimiento.php?id={$row['ID']}\" 
                                onclick=\"return confirm('¿Estás seguro de eliminar este movimiento?');\">
                                <i class=\"fas fa-trash-alt\"></i> Eliminar </a>
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
    $Numero_Expediente = $_POST['Numero_Expediente'];
    $detalle = $conn->real_escape_string($_POST['detalle']);
    $estado_id = $_POST['estado_id'];
    $fecha_movimiento = $conn->real_escape_string($_POST['fecha_movimiento']);

    // Verificar si el Número de Expediente es válido
    $checkQuery = "SELECT ID FROM Causas WHERE Numero_Expediente = '$Numero_Expediente'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $causaID = $result->fetch_assoc()['ID'];

        $sql = "INSERT INTO Seguimiento (Causa_ID, Detalle, Estado_ID, Fecha_Movimiento) 
                VALUES ('$causaID', '$detalle', '$estado_id', '$fecha_movimiento')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Paso procesal registrado con éxito.</p>";
            if (!headers_sent()) {
                header("Location: seguimientos.php");
                ob_end_flush();
                exit;
            } else {
                echo "<p>Los encabezados ya fueron enviados. Por favor, recarga la página manualmente.</p>";
            }
        } else {
            echo "<p>Error al registrar el paso procesal: " . $conn->error . "</p>";
            echo "<p>Consulta ejecutada: $sql</p>";
        }
    } else {
        echo "<p>Error: Número de expediente no válido.</p>";
    }
}

    ?>
</body>

</html>