(function () {
    const listElements = document.querySelectorAll('.menu__item');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');
    let lastActiveElement = null;  // Para recordar el menú activo en móvil

    const toggleSubmenu = (element) => {
        const subMenu = element.querySelector('.menu__nesting');
        const arrow = element.querySelector('.menu__arrow');
        
        const isActive = element.classList.toggle('menu__item--active');
        
        if (subMenu) {
            subMenu.style.height = isActive ? `${subMenu.scrollHeight}px` : '0';
        }

        if (arrow) {
            arrow.style.transform = isActive ? 'rotate(0deg)' : 'rotate(-90deg)';
        }

        // Guarda el último menú activo para restaurar su flecha
        if (isActive) {
            lastActiveElement = element;
        }
    };

    const closeAllSubmenus = () => {
        listElements.forEach(element => {
            const subMenu = element.querySelector('.menu__nesting');
            const arrow = element.querySelector('.menu__arrow');

            if (subMenu) {
                subMenu.style.height = '0';
            }

            if (arrow) {
                arrow.style.transform = 'rotate(-90deg)';
            }

            element.classList.remove('menu__item--active');
        });
    };

    const handleResize = () => {
        if (window.innerWidth > 800) {
            closeAllSubmenus();

            // Solo ajustar la flecha sin abrir el submenú
            if (lastActiveElement) {
                const arrow = lastActiveElement.querySelector('.menu__arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }

            if (list.classList.contains('menu__links--show')) {
                list.classList.remove('menu__links--show');
            }
        } else if (lastActiveElement) {
            // Reabrir el menú activo si regresamos a móvil
            toggleSubmenu(lastActiveElement);
        }
    };

    const addClickEvents = () => {
        listElements.forEach(element => {
            element.addEventListener('click', (event) => {
                event.stopPropagation();

                const isActive = element.classList.contains('menu__item--active');

                closeAllSubmenus();

                if (!isActive) {
                    toggleSubmenu(element);
                }
            });
        });
    };

    window.addEventListener('resize', handleResize);
    addClickEvents();

    menu.addEventListener('click', () => list.classList.toggle('menu__links--show'));
})();
