//redirecciona a la página de "gestión de clientes" cuando apretamos en "agregar cliente" (pantalla gestion de causas)
function openClientePage() {
    window.location.href = '/Proyecto_abogados/views/clientes.php';
}


//nos abre un popup cuando apretamos en "agregar cliente" (pantalla gestion de causas)

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
                                <button type="submit" name="agregar">Agregar Cliente</button>
                                <button type="button" onclick="closePopup()">Cerrar</button>
                            </form>
                        `;
    document.body.appendChild(popup);
}

//manejo de popup utilada (abre popup)
function openPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}
//manejo de popup utilada (cierra popup)
function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function openPopup1() {
    document.getElementById('popup1').style.display = 'block';
    document.getElementById('overlay1').style.display = 'block';
}
//manejo de popup utilada (cierra popup)
function closePopup1() {
    document.getElementById('popup1').style.display = 'none';
    document.getElementById('overlay1').style.display = 'none';
}



//funcion utilizada para filtrar las tablas
function filterTable(columnIndex) {
    const inputs = document.querySelectorAll('.filter-container input');
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
        let visible = true;
        inputs.forEach((input, index) => {
            const cell = row.cells[index];
            if (cell && input.value) {
                const text = cell.textContent.toLowerCase();
                const search = input.value.toLowerCase();
                if (!text.includes(search)) {
                    visible = false;
                }
            }
        });
        row.style.display = visible ? '' : 'none';
    });
}





//otra cvrsion de agregar cliente popup (***NO UTILIZADA***)
function openAgregarClientePopup() {
    // Crear la capa de overlay
    const overlay = document.createElement('div');
    overlay.className = 'overlay';
    overlay.id = 'overlay';
    overlay.onclick = closePopup;

    // Crear el popup
    const popup = document.createElement('div');
    popup.className = 'popup';
    popup.id = 'popup';

    // Contenido del popup
    popup.innerHTML = `
        <div class="popup-header">Agregar Cliente</div>
        <form action="clientes.php" method="POST">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="contacto">Contacto:</label>
            <input type="text" id="contacto" name="contacto">

            <label for="otros_datos">Otros Datos:</label>
            <textarea id="otros_datos" name="otros_datos"></textarea>

            <button type="submit" name="agregar">Agregar Cliente</button>
            <button type="button" onclick="closePopup1()">Cancelar</button>
        </form>
    `;

    // Agregar el overlay y el popup al cuerpo de la página
    document.body.appendChild(overlay);
    document.body.appendChild(popup);
}
//otra vrsion para el manejo de popup (NO UTILIZADA)
function closePopup() {
    // Eliminar el overlay y el popup si existen
    const overlay = document.getElementById('overlay');
    const popup = document.getElementById('popup');
    if (overlay) document.body.removeChild(overlay);
    if (popup) document.body.removeChild(popup);
}


