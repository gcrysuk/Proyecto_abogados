<?php
// views/causas.php
include_once '../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Causas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Gestión de Causas</h1>

    <!-- Formulario para agregar una causa -->
    <form action="causas.php" method="POST">
        <label for="numero_expediente">Número de Expediente:</label>
        <input type="text" id="numero_expediente" name="numero_expediente" required>

        <label for="cliente_dni">Cliente (DNI):</label>
        <select id="cliente_dni" name="cliente_dni" required>
            <?php
            $clientes = $conn->query("SELECT DNI, Nombre FROM Clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                echo "<option value='{$cliente['DNI']}'>DNI: {$cliente['DNI']} - {$cliente['Nombre']}</option>";
            }
            ?>
        </select>

        <label for="juzgado_id">Juzgado:</label>
        <select id="juzgado_id" name="juzgado_id" required>
            <?php
            $juzgados = $conn->query("SELECT ID, Nombre FROM Juzgados");
            while ($juzgado = $juzgados->fetch_assoc()) {
                echo "<option value='{$juzgado['ID']}'>{$juzgado['Nombre']}</option>";
            }
            ?>
        </select>

        <label for="objeto_id">Objeto:</label>
        <select id="objeto_id" name="objeto_id" required>
            <?php
            $objetos = $conn->query("SELECT ID, Descripcion FROM Objeto");
            while ($objeto = $objetos->fetch_assoc()) {
                echo "<option value='{$objeto['ID']}'>{$objeto['Descripcion']}</option>";
            }
            ?>
        </select>

        <label for="perito_id">Perito:</label>
        <select id="perito_id" name="perito_id">
            <option value="">Ninguno</option>
            <?php
            $peritos = $conn->query("SELECT ID, Nombre FROM Peritos");
            while ($perito = $peritos->fetch_assoc()) {
                echo "<option value='{$perito['ID']}'>{$perito['Nombre']}</option>";
            }
            ?>
        </select>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>

        <label for="fecha_alta">Fecha de Alta:</label>
        <input type="date" id="fecha_alta" name="fecha_alta" required>

        <button type="submit" name="agregar">Agregar Causa</button>
    </form>

    <hr>

    <!-- Lista de causas -->
    <h2>Lista de Causas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Expediente</th>
                <th>Cliente (DNI)</th>
                <th>Juzgado</th>
                <th>Objeto</th>
                <th>Perito</th>
                <th>Descripción</th>
                <th>Fecha de Alta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT Causas.ID, Numero_Expediente, Clientes.DNI AS ClienteDNI, Clientes.Nombre AS ClienteNombre, 
                           Juzgados.Nombre AS Juzgado, Objeto.Descripcion AS Objeto, Peritos.Nombre AS Perito, 
                           Causas.Descripcion, Fecha_Alta
                    FROM Causas
                    LEFT JOIN Clientes ON Causas.Cliente_DNI = Clientes.DNI
                    LEFT JOIN Juzgados ON Causas.Juzgado_ID = Juzgados.ID
                    LEFT JOIN Objeto ON Causas.Objeto_ID = Objeto.ID
                    LEFT JOIN Peritos ON Causas.Perito_ID = Peritos.ID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['Numero_Expediente']}</td>";
                    echo "<td>{$row['ClienteDNI']} - {$row['ClienteNombre']}</td>";
                    echo "<td>{$row['Juzgado']}</td>";
                    echo "<td>{$row['Objeto']}</td>";
                    echo "<td>{$row['Perito']}</td>";
                    echo "<td>{$row['Descripcion']}</td>";
                    echo "<td>{$row['Fecha_Alta']}</td>";
                    echo "<td>
                            <a href='editar_causa.php?id={$row['ID']}'>Editar</a>
                            <a href='eliminar_causa.php?id={$row['ID']}' onclick='return confirm(\"¿Estás seguro de eliminar esta causa?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No hay causas registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Procesar formulario de agregar causa
    if (isset($_POST['agregar'])) {
        $numero_expediente = $_POST['numero_expediente'];
        $cliente_dni = $_POST['cliente_dni'];
        $juzgado_id = $_POST['juzgado_id'];
        $objeto_id = $_POST['objeto_id'];
        $perito_id = $_POST['perito_id'] ?: 'NULL';
        $descripcion = $_POST['descripcion'];
        $fecha_alta = $_POST['fecha_alta'];

        $sql = "INSERT INTO Causas (Numero_Expediente, Cliente_DNI, Juzgado_ID, Objeto_ID, Perito_ID, Descripcion, Fecha_Alta) 
                VALUES ('$numero_expediente', '$cliente_dni', '$juzgado_id', '$objeto_id', $perito_id, '$descripcion', '$fecha_alta')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Causa agregada con éxito.</p>";
            header("Refresh:0"); // Recargar la página
        } else {
            echo "<p>Error al agregar causa: " . $conn->error . "</p>";
        }
    }
    ?>
</body>
</html>
