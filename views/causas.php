<?php
ob_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>Gestión de Causas</header>

    <!-- Formulario para agregar una causa -->
    <form action="causas.php" method="POST">
        <label for="numero_expediente">Número de Expediente:</label>
        <input type="text" id="numero_expediente" name="numero_expediente" required>

        <label for="cliente_dni">Cliente (DNI):</label>
        <select id="cliente_dni" name="cliente_dni" required>
            <?php
            $clientes = $conn->query("SELECT DNI, Nombre FROM Clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                echo "<option value='{$cliente['Nombre']} - {$cliente['DNI']}'>DNI: {$cliente['DNI']} </option>";
            }
            ?>
            <option value="add">Agregar un nuevo cliente</option>
        </select>

        <script>
        document.getElementById('cliente_dni').addEventListener('change', function() {
            if (this.value === 'add') {
                window.location.href = 'clientes.php?return=causas.php';
            }
        });
        </script>

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

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>

        <label for="fecha_alta">Fecha de Alta:</label>
        <input type="date" id="fecha_alta" name="fecha_alta" required>

        <button type="submit" name="agregar">Agregar Causa</button>
    </form>

    <hr>

    <!-- Lista de causas -->
    <h2>Lista de Causas</h2>
    <table>
        <thead>
            <tr>
                <th>Número de Expediente</th>
                <th>Carátula</th>
                <th>Cliente (DNI)</th>
                <th>Juzgado</th>
                <th>Objeto</th>
                <th>Fecha de Alta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT Numero_Expediente, Clientes.DNI AS ClienteDNI, Clientes.Nombre AS ClienteNombre 
                           Juzgados.Nombre AS Juzgado, Objeto.Descripcion AS Objeto, 
                           Causas.Descripcion AS Caratula, Fecha_Alta
                    FROM Causas
                    LEFT JOIN Clientes ON Causas.Cliente_DNI = Clientes.DNI
                    LEFT JOIN Juzgados ON Causas.Juzgado_ID = Juzgados.ID
                    LEFT JOIN Objeto ON Causas.Objeto_ID = Objeto.ID
                    $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row[\"Numero_Expediente\"]}</td>";
                    echo "<td>{$row[\"Caratula\"]}</td>";
                    echo "<td>{$row[\"ClienteNombre\"]} - {$row[\"ClienteDNI\"]} </td>";
                    echo "<td>{$row[\"Juzgado\"]}</td>";
                    echo "<td>{$row[\"Objeto\"]}</td>";
                    echo "<td>{$row['Fecha_Alta']}</td>";
                    echo "<td class=\"action-buttons\">
                            <a class='edit' href='editar_causa.php?id={$row['ID']}'><i class='fas fa-edit'></i> Editar</a>
                            <a class='delete' href='eliminar_causa.php?id={$row['ID']}' onclick='return confirm(\"¿Estás seguro de eliminar esta causa?\");'><i class='fas fa-trash-alt'></i> Eliminar</a>
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
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha_alta = $conn->real_escape_string($_POST['fecha_alta']);

        $sql = "INSERT INTO Causas (Numero_Expediente, Cliente_DNI, Juzgado_ID, Objeto_ID, Descripcion, Fecha_Alta) 
                VALUES ('$numero_expediente', '$cliente_dni', '$juzgado_id', '$objeto_id', '$descripcion', '$fecha_alta');

        if ($conn->query($sql) === TRUE) {
            echo "<p>Causa agregada con éxito.</p>";
            if (!headers_sent()) {
    header("Refresh:0");
    ob_end_flush();
} else {
    echo "<p>Los encabezados ya fueron enviados. Por favor, recarga la página manualmente.</p>";
} // Recargar la página
        } else {
            echo "<p>Error al agregar causa: " . $conn->error . "</p>";
            echo "<p>Consulta ejecutada: $sql</p>";
        }
    }
    ?>
</body>

</html>