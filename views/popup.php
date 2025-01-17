<!-- Primer Overlay y Popup -->
<div class="overlay" id="overlay1" onclick="closePopup('popup1', 'overlay1')"></div>
<div class="popup" id="popup1">
    Este es el primer popup.
    <button onclick="openPopup('popup2', 'overlay2')">Abrir segundo popup</button>
    <button onclick="closePopup('popup1', 'overlay1')">Cerrar</button>
</div>

<!-- Segundo Overlay y Popup -->
<div class="overlay" id="overlay2" onclick="closePopup('popup2', 'overlay2')"></div>
<div class="popup" id="popup2">
    Este es el segundo popup (superpuesto).
    <button onclick="closePopup('popup2', 'overlay2')">Cerrar</button>
</div>

<!-- Botón para abrir el primer popup -->
<button onclick="openPopup('popup1', 'overlay1')">Mostrar primer popup</button>

<!-- Estilos CSS -->
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo oscuro con opacidad */
        z-index: 999;
        /* Para que se superponga sobre otros elementos */
        display: none;
        /* Por defecto, oculto */
    }

    .popup {
        position: fixed;
        background-color: white;
        border: 1px solid black;
        padding: 20px;
        z-index: 1000;
        /* Para que el popup esté por encima del overlay */
        display: none;
        /* Por defecto, oculto */
        width: 300px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Centrado */
    }
</style>

<!-- JavaScript para manejar popups -->
<script>
    // Función para abrir un popup
    function openPopup(popupId, overlayId) {
        document.getElementById(popupId).style.display = "block";
        document.getElementById(overlayId).style.display = "block";
    }

    // Función para cerrar un popup
    function closePopup(popupId, overlayId) {
        document.getElementById(popupId).style.display = "none";
        document.getElementById(overlayId).style.display = "none";
    }
</script>