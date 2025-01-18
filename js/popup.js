// Abrir Popup
function openPopup(popupId, overlayId) {
    document.getElementById(overlayId).style.display = "block";
    document.getElementById(popupId).style.display = "block";
}

// Cerrar Popup
function closePopup(popupId, overlayId) {
    document.getElementById(overlayId).style.display = "none";
    document.getElementById(popupId).style.display = "none";
}