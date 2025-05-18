(function(){
    const listElements = document.querySelectorAll('.menu__item--show');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');

    const addClick = () => {
        listElements.forEach(element => {
            element.addEventListener('click', () => {
                let subMenu = element.children[1];
                let arrow = element.querySelector('.menu__arrow');
                let height = 0;
                
                element.classList.toggle('menu__item--active');
                
                if (subMenu.clientHeight === 0) {
                    height = subMenu.scrollHeight;
                    // Ajusta la flecha cuando el submenu está abierto
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    // Vuelve la flecha a la posición inicial (derecha)
                    arrow.style.transform = 'rotate(-90deg)';
                }

                subMenu.style.height = `${height}px`;
            });
        });
    }

    const deleteStyleHeight = () => {
        listElements.forEach(element => {
            if (element.children[1].getAttribute('style')) {
                element.children[1].removeAttribute('style');
                element.classList.remove('menu__item--active');
                
                // Restablece la rotación de las flechas
                const arrow = element.querySelector('.menu__arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(-90deg)';
                }
            }
        });
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth > 800) {
            deleteStyleHeight();
            if (list.classList.contains('menu__links--show'))
                list.classList.remove('menu__links--show');
        } else {
            addClick();
        }
    });

    if (window.innerWidth <= 800) {
        addClick();
    }

    menu.addEventListener('click', () => list.classList.toggle('menu__links--show'));
})();
