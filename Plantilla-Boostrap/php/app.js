document.addEventListener('DOMContentLoaded', () => {
    // Lógica menú móvil
    const btnAdminMenu = document.getElementById('btn-admin-menu');
    const adminAside = document.getElementById('admin-aside');
    if (btnAdminMenu && adminAside) {
        btnAdminMenu.addEventListener('click', () => adminAside.classList.toggle('active'));
    }
});

// Lógica Modal Eliminar
function confirmarEliminacion(event) {
    event.preventDefault(); 
    const btnPresionado = event.currentTarget;
    const formulario = btnPresionado.closest('form');
    
    const myModal = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
    myModal.show();
    
    const btnConfirmar = document.getElementById('btn-confirmar-accion');
    btnConfirmar.onclick = function() {
        myModal.hide();
        const inputOculto = document.createElement('input');
        inputOculto.type = 'hidden';
        inputOculto.name = btnPresionado.name;
        inputOculto.value = btnPresionado.value;
        formulario.appendChild(inputOculto);
        formulario.submit(); 
    };
}