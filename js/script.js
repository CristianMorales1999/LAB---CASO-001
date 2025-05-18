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
    activeParent = element.classList.contains('menu__item--active')
      ? element
      : null
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

          //mostrar el contenido del item seleccionado y el subitem
          console.log({
            'Menú Principal': activeParent
              ? activeParent.childNodes[3].childNodes[0].textContent.trim()
              : 'Ninguno',
            'Submenú Seleccionado': activeChild
              ? activeChild.textContent.trim()
              : 'Ninguno'
          })

          // Añade la clase activa al subitem seleccionado
          subItems.forEach(si => si.classList.remove('menu__link--active'))
          subItem.classList.add('menu__link--active')
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

//_____________________________________________________________________________________
//__________________________LOGICA DE CARGA DE CONTENIDO AJAX__________________________
//_____________________________________________________________________________________

function cargarURL (url, contenedor, efectoDeCarga = true) {
  // Esperar n minilisegundos antes de mostrar el loader
  if (efectoDeCarga) {
    mostrarLoader(300)
  }

  // Realizar la petición AJAX
  $.get(url, {}, function (data) {
    $(`#${contenedor}`).html(data)
  }).fail(function () {
    $(`#${contenedor}`).html(`
        <div class="error">
          <h2>Error al cargar el contenido</h2>
        </div>
      `)
  })
}

function mostrarLoader (milisegundos = 1000) {
  document.getElementById('loader').style.display = 'flex'
  setTimeout(
    () => (document.getElementById('loader').style.display = 'none'),
    milisegundos
  )
}
