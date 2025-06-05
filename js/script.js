;(function () {
  const listElements = document.querySelectorAll('.menu__item')
  const list = document.querySelector('.menu__links')
  const menu = document.querySelector('.menu__hamburguer')
  let activeParent = null
  let activeChild = null

  const toggleSubmenu = element => {
    const subMenu = element.querySelector('.menu__nesting')
    const arrow = element.querySelector('.menu__arrow')
    const isActive = element.classList.contains('menu__item--active')

    // Desactivar todos los submenús si no se está cerrando el actual
    if (!isActive) {
      closeAllSubmenus()
    }

    // Alterna la clase activa
    element.classList.toggle('menu__item--active')

    // Ajusta la orientación de la flecha
    if (arrow) {
      arrow.style.transform = isActive ? 'rotate(-90deg)' : 'rotate(0deg)'
    }

    // Ajusta la altura del submenu
    if (subMenu) {
      subMenu.style.height = isActive ? '0' : `${subMenu.scrollHeight}px`
    }

    // Guarda el estado del menú principal seleccionado
    if (!isActive) {
      activeParent = element
      markActiveParent()
    } else {
      activeParent = null
    }
  }

  const closeAllSubmenus = () => {
    listElements.forEach(element => {
      const subMenu = element.querySelector('.menu__nesting')
      const arrow = element.querySelector('.menu__arrow')
      if (subMenu) subMenu.style.height = '0'
      if (arrow) arrow.style.transform = 'rotate(-90deg)'
      element.classList.remove('menu__item--active')
    })
  }

  const markActiveParent = () => {
    listElements.forEach(element => {
      const link = element.querySelector('.menu__link')
      if (element === activeParent) {
        link.style.backgroundColor = '#4A5568' // Fondo gris
      } else {
        link.style.backgroundColor = ''
      }
    })
  }

  const markActiveChild = () => {
    const allSubItems = document.querySelectorAll('.menu__link--inside')
    allSubItems.forEach(subItem => {
      if (subItem === activeChild) {
        subItem.style.backgroundColor = '#718096' // Fondo más claro
      } else {
        subItem.style.backgroundColor = ''
      }
    })
  }

  const handleResize = () => {
    if (window.innerWidth > 800) {
      closeAllSubmenus()
      if (list.classList.contains('menu__links--show')) {
        list.classList.remove('menu__links--show')
      }
      // Mantén el menú principal seleccionado activo en vista desktop
      if (activeParent) {
        activeParent.classList.add('menu__item--active')
        const arrow = activeParent.querySelector('.menu__arrow')
        if (arrow) arrow.style.transform = 'rotate(0deg)'
      }
      // Mantén el fondo del menú principal activo
      markActiveParent()
      markActiveChild()
    }
  }

  const addClickEvents = () => {
    listElements.forEach(element => {
      element.addEventListener('click', event => {
        event.stopPropagation()
        toggleSubmenu(element)
      })

      // Maneja selección de submenú
      const subItems = element.querySelectorAll('.menu__link--inside')
      subItems.forEach(subItem => {
        subItem.addEventListener('click', event => {
          event.stopPropagation()

          // Cierra el menú hamburguesa en móvil
          if (window.innerWidth <= 800) {
            list.classList.remove('menu__links--show')
          }

          // Guarda el estado del menú seleccionado
          activeParent = element
          activeChild = subItem

          // Marca los elementos seleccionados
          markActiveParent()
          markActiveChild()

          // Obtener textos para construir la URL dinámica
          const menuText = activeParent
            ? activeParent
                .querySelector('.menu__link')
                .textContent.trim()
                .toLowerCase()
                .replace(/ /g, '_')
            : ''
          const submenuText = activeChild
            ? activeChild.textContent.trim().toLowerCase().replace(/ /g, '_')
            : ''

          // Construye la URL
          const url = `views/${submenuText}.php`

          // console.log(submenuText)
          if (submenuText === 'consultar') {
            cargarURL(url, 'container', true, { tabla: menuText }, function () {
              inicializarBusquedaPorColumna() // Se ejecuta después de que el contenido se cargue
            })
          } else if(submenuText=='actualizar' || submenuText=='eliminar'){//Si desea hacer la accion de actualizar o eliminar
            cargarURL('views/listar.php', 'container', true,{ 
              tabla: menuText,
              accion: submenuText,
            })
          }else if(submenuText=="listar" || submenuText=="registrar"){//Solo listar tal cual
            cargarURL(url, 'container', true, { tabla: menuText })
          }
          else{//Consultas
            const coincidencia = submenuText.match(/\d+/);
            const consulta = parseInt(coincidencia[0], 10);
            cargarURL("views/consultas.php", 'container', true, { nroDeConsulta: consulta })
          }
        })
      })
    })
  }

  // Inicialización de eventos
  window.addEventListener('resize', handleResize)
  addClickEvents()

  // Manejo del botón hamburguesa
  menu.addEventListener('click', () =>
    list.classList.toggle('menu__links--show')
  )
})()
