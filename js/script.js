(function(){
    const listElements = document.querySelectorAll('.menu__item--show');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');

    const addClick = () => {
        listElements.forEach(element => {
            element.addEventListener('click', () => {
                // Cierra otros submenús antes de abrir el actual
                listElements.forEach(el => {
                    if (el !== element) {
                        const subMenu = el.children[1];
                        const arrow = el.querySelector('.menu__arrow');
                        
                        if (subMenu.clientHeight > 0) {
                            subMenu.style.height = '0';
                            el.classList.remove('menu__item--active');
                            if (arrow) arrow.style.transform = 'rotate(-90deg)';
                        }
                    }
                });

                // Abre o cierra el menú actual
                let subMenu = element.children[1];
                let arrow = element.querySelector('.menu__arrow');
                let height = 0;
                
                element.classList.toggle('menu__item--active');
                
                if (subMenu.clientHeight === 0) {
                    height = subMenu.scrollHeight;
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                } else {
                    if (arrow) arrow.style.transform = 'rotate(-90deg)';
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
                
                const arrow = element.querySelector('.menu__arrow');
                if (arrow) arrow.style.transform = 'rotate(-90deg)';
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
