(function () {
    const listElements = document.querySelectorAll('.menu__item');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');
    let lastActiveElement = null;

    const toggleSubmenu = (element) => {
        const subMenu = element.querySelector('.menu__nesting');
        const arrow = element.querySelector('.menu__arrow');
        const isActive = element.classList.contains('menu__item--active');
        const isAlreadyActive = element === lastActiveElement;
        
        // Si el elemento ya estaba activo, lo desactivamos
        if (isActive && isAlreadyActive) {
            element.classList.remove('menu__item--active');
            if (subMenu) subMenu.style.height = '0';
            if (arrow) arrow.style.transform = 'rotate(-90deg)';
            lastActiveElement = null;
        } else {
            // Cerramos todos los submenús antes de abrir el nuevo
            closeAllSubmenus();
            element.classList.add('menu__item--active');
            if (subMenu) subMenu.style.height = `${subMenu.scrollHeight}px`;
            if (arrow) arrow.style.transform = 'rotate(0deg)';
            lastActiveElement = element;
        }
    };

    const closeAllSubmenus = () => {
        listElements.forEach(element => {
            const subMenu = element.querySelector('.menu__nesting');
            const arrow = element.querySelector('.menu__arrow');

            if (subMenu) subMenu.style.height = '0';
            if (arrow) arrow.style.transform = 'rotate(-90deg)';
            element.classList.remove('menu__item--active');
        });
    };

    const handleResize = () => {
        if (window.innerWidth > 800) {
            closeAllSubmenus();
            if (lastActiveElement) {
                lastActiveElement.classList.add('menu__item--active');
                const arrow = lastActiveElement.querySelector('.menu__arrow');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
            list.classList.remove('menu__links--show');
        } else {
            if (lastActiveElement) {
                const subMenu = lastActiveElement.querySelector('.menu__nesting');
                if (subMenu) subMenu.style.height = `${subMenu.scrollHeight}px`;
            }
        }
    };

    const addClickEvents = () => {
        listElements.forEach(element => {
            element.addEventListener('click', (event) => {
                event.stopPropagation();
                toggleSubmenu(element);
            });
        });
    };

    window.addEventListener('resize', handleResize);
    addClickEvents();
    menu.addEventListener('click', () => list.classList.toggle('menu__links--show'));
})();
