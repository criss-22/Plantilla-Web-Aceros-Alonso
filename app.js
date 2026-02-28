//Slider de categorias---------------------------------
let currentIndex = 0;

function moveSlide(direction) {
    const slider = document.getElementById("slider");
  if (!slider) return; // Si no hay slider en esta página, no hace nada

    const items = slider.children;
  if (items.length <= 1) return; // Si solo hay 1 o 0 categorías, no hay nada que deslizar

  // Calculamos la distancia exacta entre el primer elemento y el segundo.
    const itemWidth = items[1].offsetLeft - items[0].offsetLeft;

  // Averiguamos cuántos elementos caben en la pantalla actual
    const visibleWidth = slider.parentElement.offsetWidth;
    const visibleItems = Math.round(visibleWidth / itemWidth);

  // Calculamos el límite máximo para que no se deslice hacia el vacío
    const maxIndex = items.length - visibleItems;

  // Actualizamos el índice sumando o restando (direction es 1 o -1)
    currentIndex += direction;

  // Ponemos los límites (si llega al principio o al final, lo detenemos)
    if (currentIndex < 0) {
    currentIndex = 0;
    } else if (currentIndex > maxIndex) {
    // Si quieres que al llegar al final regrese al principio, cambia esto por: currentIndex = 0;
    currentIndex = maxIndex;
    }

  // Aplicamos el movimiento usando la propiedad transform
  slider.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
}

// Un pequeño truco de UX: Si el usuario gira el celular o cambia el tamaño de la ventana,
// reseteamos el slider al inicio para que no se rompa visualmente.
window.addEventListener("resize", () => {
    currentIndex = 0;
    const slider = document.getElementById("slider");
    if (slider) {
    slider.style.transform = `translateX(0px)`;
    }
});

//Menu desplegable---------------------------

document.addEventListener("DOMContentLoaded", () => {
    const btnMenu = document.getElementById("btn-menu");
    const menuPrincipal = document.getElementById("menu-principal");
    if (btnMenu && menuPrincipal) {
    // Le "escuchamos" el clic al botón
    btnMenu.addEventListener("click", () => {
    menuPrincipal.classList.toggle("hidden");
    });
    }
});

//Sub- Menu de productos, Categorias, Acerca de nosotros
document.addEventListener('DOMContentLoaded', () => {
    
    const btnMenu = document.getElementById('btn-menu');
    const menuPrincipal = document.getElementById('menu-principal');

    if (btnMenu && menuPrincipal) {
        btnMenu.addEventListener('click', () => {
            menuPrincipal.classList.toggle('hidden');
        });
    }

    // LÓGICA DE LOS SUBMENÚS (Categorías, Productos, etc.) ---
    const submenuBtns = document.querySelectorAll('.submenu-btn');

    submenuBtns.forEach(btn => {
        // Usamos una función tradicional para no perder el contexto de 'this'
        btn.addEventListener('click', function(event) {
            
            // Verificamos si la pantalla es tamaño móvil (< 768px según Tailwind)
            if (window.innerWidth < 768) {
                event.preventDefault(); // Detiene el salto del enlace '#'
                
                // Busca el contenedor <ul> que le sigue a este enlace
                const submenu = this.nextElementSibling;
                
                if (submenu) {
                    // Cierra los demás submenús abiertos (opcional pero recomendado)
                    document.querySelectorAll('.submenu-btn + ul').forEach(otherMenu => {
                        if (otherMenu !== submenu) {
                            otherMenu.classList.add('hidden');
                            otherMenu.classList.remove('flex');
                        }
                    });

                    // Despliega u oculta el submenú que tocaste
                    submenu.classList.toggle('hidden');
                    submenu.classList.toggle('flex');
                }
            }
        });
    });

});
