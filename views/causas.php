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
    <style>
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        width: 400px;
        max-width: 90%;
    }

    .popup-header {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .popup button {
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup button:hover {
        background-color: #0056b3;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .add-causa-btn {
        display: flex;
        align-items: center;
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .add-causa-btn i {
        margin-right: 5px;
    }

    .add-causa-btn:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <a href="../index.php"
        style="display: inline-block; margin-bottom: 20px; background-color: #007BFF; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;"><i
            class='fas fa-home'></i> Inicio</a>
    <header>Gestión de Causas</header>

    <!-- Botón para abrir el formulario en un popup -->
    <div class="add-causa-btn" onclick="openPopup()">
        <i class="fas fa-folder-plus"></i> Agregar Causa
    </div>

    <!-- Popup para agregar causa -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
        <div class="popup-header">Agregar Causa</div>
        <form action="causas.php" method="POST">
            <label for="numero_expediente">Número de Expediente:</label>
            <input type="text" id="numero_expediente" name="numero_expediente" required>

            <label for="caratula">Carátula:</label>
            <textarea id="caratula" name="caratula"></textarea>

            <label for="cliente_dni">Cliente:</label>
            <input type="text" id="cliente_dni_search" placeholder="Buscar cliente..."
                style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            <select id="cliente_dni" name="cliente_dni" required style="margin-top: 10px; width: 100%;">
                <option value="">Seleccione un cliente</option>
                <?php
                $clientes = $conn->query("SELECT DNI, Nombre FROM Clientes ORDER BY Nombre ASC");
                while ($cliente = $clientes->fetch_assoc()) {
                    echo "<option value='{$cliente['DNI']}'> {$cliente['Nombre']} - DNI: {$cliente['DNI']}</option>";
                }
                ?>
                <option value="add">+ Agregar Nuevo Cliente</option>
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

            <label for="fecha_alta">Fecha de Alta:</label>
            <input type="date" id="fecha_alta" name="fecha_alta" required>

            <button type="submit" name="agregar">Agregar Causa</button>
            <button type="button" onclick="closePopup()">Cancelar</button>
        </form>
    </div>

    <script>
    document.getElementById('cliente_dni').addEventListener('change', function() {
        if (this.value === 'add') {
            openClientePopup();
        }
    });

    function openPopup() {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    function openClientePopup() {
        const popup = document.createElement('div');
        popup.style.position = 'fixed';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.backgroundColor = 'white';
        popup.style.padding = '20px';
        popup.style.borderRadius = '10px';
        popup.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        popup.style.zIndex = '1000';
        popup.innerHTML = `
                <h2>Agregar Nuevo Cliente</h2>
                <form action="clientes.php" method="POST">
                    <label for="nuevo_dni">DNI:</label>
                    <input type="text" id="nuevo_dni" name="dni" required>
                    <label for="nuevo_nombre">Nombre:</label>
                    <input type="text" id="nuevo_nombre" name="nombre" required>
                    <label for="nuevo_contacto">Contacto:</label>
                    <input type="text" id="nuevo_contacto" name="contacto">
                    <label for="nuevo_otros">Otros Datos:</label>
                    <textarea id="nuevo_otros" name="otros_datos"></textarea>
                    <button type="submit">Guardar</button>
                    <button type="button" onclick="document.body.removeChild(this.parentNode)">Cerrar</button>
                </form>
            `;
        document.body.appendChild(popup);
    }
    </script>

</body>

</html>