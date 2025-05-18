(function () {
    const listElements = document.querySelectorAll('.menu__item');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');

    const toggleSubmenu = (element) => {
        const subMenu = element.querySelector('.menu__nesting');
        const arrow = element.querySelector('.menu__arrow');
        
        // Alterna la clase activa
        const isActive = element.classList.toggle('menu__item--active');
        
        // Ajusta la altura del submenu
        if (subMenu) {
            subMenu.style.height = isActive ? `${subMenu.scrollHeight}px` : '0';
        }

        // Ajusta la orientación de la flecha
        if (arrow) {
            arrow.style.transform = isActive ? 'rotate(0deg)' : 'rotate(-90deg)';
        }
    };

    const closeAllSubmenus = () => {
        listElements.forEach(element => {
            const subMenu = element.querySelector('.menu__nesting');
            const arrow = element.querySelector('.menu__arrow');

            // Resetea cada submenu
            if (subMenu) {
                subMenu.style.height = '0';
            }

            // Resetea cada flecha
            if (arrow) {
                arrow.style.transform = 'rotate(-90deg)';
            }

            // Remueve la clase activa
            element.classList.remove('menu__item--active');
        });
    };

    const handleResize = () => {
        if (window.innerWidth > 800) {
            closeAllSubmenus();
            if (list.classList.contains('menu__links--show')) {
                list.classList.remove('menu__links--show');
            }
        }
    };

    const addClickEvents = () => {
        listElements.forEach(element => {
            element.addEventListener('click', (event) => {
                event.stopPropagation();

                // Cierra otros submenús antes de abrir el actual
                closeAllSubmenus();
                toggleSubmenu(element);
            });
        });
    };

    // Inicialización de eventos
    window.addEventListener('resize', handleResize);
    addClickEvents();

    // Manejo del botón hamburguesa
    menu.addEventListener('click', () => list.classList.toggle('menu__links--show'));
})();
