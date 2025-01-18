// Detectar cuando se selecciona un valor del datalist
searchInput.addEventListener('input', () => {
    const selectedOption = Array.from(datalist.options).find(option => option.value === searchInput.value);

    if (selectedOption) {
        // Extraer el DNI del atributo data-dni y asignarlo al campo oculto
        hiddenDniInput.value = selectedOption.getAttribute('data-dni');
    } else {
        // Si no hay coincidencia, limpiar el campo oculto
        hiddenDniInput.value = '';
    }
});