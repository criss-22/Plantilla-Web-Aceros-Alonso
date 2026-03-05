document.addEventListener('DOMContentLoaded', () => {
    const btnAdminMenu = document.getElementById('btn-admin-menu');
    const adminAside = document.getElementById('admin-aside');

    if (btnAdminMenu && adminAside) {
        btnAdminMenu.addEventListener('click', () => {
            adminAside.classList.toggle('active');
        });
    }
});


// Función para crear y mostrar Toasts dinámicamente
function mostrarToast(mensaje, tipo = 'exito') {
    const toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        console.error('No se encontró el contenedor de toasts');
        return;
    }

    // Definir el estilo según el tipo de acción
    let bgClass = 'bg-success'; // Verde por defecto
    let icono = '✅';
    let titulo = 'Éxito';

    if (tipo === 'error') {
        bgClass = 'bg-danger'; // Rojo
        icono = '❌';
        titulo = 'Error';
    } else if (tipo === 'advertencia') {
        bgClass = 'bg-warning text-dark'; // Amarillo
        icono = '⚠️';
        titulo = 'Advertencia';
    } else if (tipo === 'info') {
        bgClass = 'bg-primary'; // Azul
        icono = 'ℹ️';
        titulo = 'Información';
    }

    // Crear el elemento HTML del Toast
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-white border-0 ${bgClass} mb-2 shadow-lg`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');

    // Estructura interna del Toast
    toastEl.innerHTML = `
        <div class="toast-header bg-transparent text-white border-0 pb-0">
            <strong class="me-auto">${icono} ${titulo}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body fw-bold px-3 py-2">
            ${mensaje}
        </div>
    `;

    // Agregar el Toast al contenedor en el HTML
    toastContainer.appendChild(toastEl);

    // Inicializar el Toast con Bootstrap (desaparece en 4 segundos)
    const bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
    bsToast.show();

    // Eliminar el código HTML del DOM cuando termine la animación de ocultado
    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}


// Función para confirmar acciones antes de enviar el formulario
function confirmarEliminacion(event) {
    // 1. Evitamos que el formulario se envíe inmediatamente
    event.preventDefault(); 
    
    // 2. Obtenemos el botón que se presionó y su formulario correspondiente
    const btnPresionado = event.currentTarget;
    const formulario = btnPresionado.closest('form');
    
    // 3. Mostramos el Modal de Bootstrap
    const modalElement = document.getElementById('modalConfirmacion');
    const myModal = new bootstrap.Modal(modalElement);
    myModal.show();
    
    // 4. ¿Qué pasa si el usuario hace clic en "Sí, Eliminar"?
    const btnConfirmar = document.getElementById('btn-confirmar-accion');
    
    // Limpiamos eventos anteriores por si acaso
    btnConfirmar.onclick = null; 
    
    btnConfirmar.onclick = function() {
        myModal.hide(); // Ocultamos el modal
        
        // Creamos un input oculto para decirle a PHP que la acción es "eliminar"
        // (Ya que al enviar por JS, el value del botón original no se manda)
        const inputOculto = document.createElement('input');
        inputOculto.type = 'hidden';
        inputOculto.name = btnPresionado.name;   // 'accion'
        inputOculto.value = btnPresionado.value; // 'eliminar'
        
        formulario.appendChild(inputOculto);
        
        // Opcional: Mostramos un toast avisando que se está procesando
        if (typeof mostrarToast === 'function') {
            mostrarToast('Procesando eliminación...', 'info');
        }
        
        // Enviamos el formulario real a PHP
        formulario.submit(); 
    };
}