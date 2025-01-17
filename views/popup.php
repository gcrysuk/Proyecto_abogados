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

<
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
