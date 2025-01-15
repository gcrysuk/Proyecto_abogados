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

    <!-- Botón para abrir el formulario en un popup -->
    <div class="add-client-btn" onclick="openPopup()">
        <i class="fas fa-folder-plus"></i> Agregar Causa
    </div>

    <!-- Popup para agregar una nueva causa -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
        <div class="popup-header">Agregar Nueva Causa</div>
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
                <option value="add">Agregar un nuevo cliente</option>
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

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea>

            <label for="fecha_alta">Fecha de Alta:</label>
            <input type="date" id="fecha_alta" name="fecha_alta" required>

            <button type="submit" name="agregar">Agregar Causa</button>
            <button type="button" onclick="closePopup()">Cancelar</button>
        </form>
    </div>

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
            <!-- Código de lista dinámica -->
        </tbody>
    </table>

    <script>
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
    </script>
</body>

</html>