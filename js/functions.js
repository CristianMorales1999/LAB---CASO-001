
function setActiveMenu(buttonId) {
    // Remover la clase activa de todos los botones
    $(".menu-button").removeClass("active");   
    // Añadir la clase activa al botón actual
    $(`#${buttonId}`).addClass("active");
}

function cargarURL(url,contenedor,efectoDeCarga=true, parametros={}) {   
  // Esperar n minilisegundos antes de mostrar el loader
  if(efectoDeCarga){
    mostrarLoader(300); 
  }

  const args=[url];
  // Verificar si hay parametro extra tablaBD
  if(Object.keys(parametros).length > 0){
    args.push(parametros);
  }
  args.push(function(data){
    $(`#${contenedor}`).html(data);
  });

  $.get(...args).fail(function() {
    $(`#${contenedor}`).html(`
      <div class="error">
        <h2>Error al cargar el contenido</h2>
      </div>
    `);
  });
}

function validarFormularioYRegistrar(tablaBD, contenedorOrUrlDeRetorno, accion="insert") {
    // Limpiar mensajes previos
    limpiarMensajesDeError();
    
    //Hacer distinción de la tabla(Empleados, Cargos y Profesiones) a la que se va a insertar para saber que campos validar
    let item = {};
    let esValido = true;

    if(tablaBD=="empleados"){
        item["nombre"] = $("#nombre").val().trim();
        item["apellidoPaterno"] = $("#apellidoPaterno").val().trim();
        item["apellidoMaterno"] = $("#apellidoMaterno").val().trim();
        item["idCargo"] = $("#cargo").val();
        item["idProfesion"] = $("#profesion").val();

        // Validación del campo nombre
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["nombre"])) {
            mostrarTextoDeError("El nombre debe contener solo letras y tener entre 3 y 100 caracteres.", "nombre");
            esValido = false;
        }
        // Validación del campo apellido paterno
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["apellidoPaterno"])) {
            mostrarTextoDeError("El apellido paterno debe contener solo letras y tener entre 3 y 100 caracteres.", "apellidoPaterno");
            esValido = false;
        }
        // Validación del campo apellido materno
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["apellidoMaterno"])) {
            mostrarTextoDeError("El apellido materno debe contener solo letras y tener entre 3 y 100 caracteres.", "apellidoMaterno");
            esValido = false;
        }
        if (item['idCargo'] === "" || item['idCargo'] === null) {
            mostrarTextoDeError("Selecciona un cargo.", "cargo");
            esValido = false;
        }
        if (item['idProfesion'] === "" || item['idProfesion'] === null) {
            mostrarTextoDeError("Selecciona una profesión.", "profesion");
            esValido = false;
        }
    }
    else if(tablaBD=="cargos"){
        item['cargo'] = $("#cargo").val();
        // Validación del campo cargo
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item['cargo'])) {
            mostrarTextoDeError("El cargo debe contener solo letras y tener entre 3 y 100 caracteres.", "cargo");
            esValido = false;
        }
    }
    else if(tablaBD=="profesiones"){
        item['profesion'] = $("#profesion").val();
        // Validación del campo profesion
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item['profesion'])) {
            mostrarTextoDeError("La profesión debe contener solo letras y tener entre 3 y 100 caracteres.", "profesion");
            esValido = false;
        }
    }

    // Si todo es válido, se procede con la inserción
    if (esValido) {
      if(accion=="insert"){
        insertarNuevoItem(tablaBD,item,contenedorOrUrlDeRetorno);//Contenedor
      }
      else if(accion=="update"){
        actualizarContacto(contenedorOrUrlDeRetorno);//Url de retorno
      }
    }
}

function insertarNuevoItem(tablaBD, nuevoItem, contenedor){
  // Realizar la petición AJAX
    $.post("BD/insertarNuevoRegistroEnUnaTabla.php", {
        'tabla': tablaBD,
        'nuevoItem': nuevoItem,
    }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
        mostrarMensajeDeExito(data.message, contenedor); 
      } else {
          mostrarMensajeDeError(data.message, contenedor);
      }
      setTimeout(function(){ cargarURL("views/listar.php",contenedor,false,{tabla:tablaBD});}, 2000);
    }
    ).fail(function() {
      mostrarMensajeDeError("Error al cargar el contenido", contenedor);
    });
}

function buscarItemPorCampo(tablaContenedor, mensajeContenedor) {
  // Obtener columna y valor a buscar
  let columna = $("#columna").val();
  let valor = $("#busqueda").val().trim();
  if (columna === "" || valor === "") {
    // Limpiar el contenedor de mensajes
      vaciarContenedor(tablaContenedor);
      mostrarMensajeDeError("Por favor, completa todos los campos", mensajeContenedor);
      return;
  }
  // Limpiar tabla antes de la nueva búsqueda
  vaciarContenedor(tablaContenedor);
  // Realizar la petición AJAX
  $.post("BD/buscarbd.php", { 
      'columna':columna, 
      'valor':valor,
  }, function(response){
      // Parsear la respuesta JSON
      let data = JSON.parse(response);
      // Limpiar el contenedor de mensajes
      vaciarContenedor(mensajeContenedor);
      if (data.status === 'success') {
          // Mostrar el mensaje de éxito brevemente
          mostrarMensajeDeExito(data.message, mensajeContenedor);
          // Mostrar la tabla después de que el mensaje desaparezca
          setTimeout(() => {
              vaciarContenedor(mensajeContenedor);  // Quitar el mensaje
              $(`#${tablaContenedor}`).html(data.tabla);  // Mostrar la nueva tabla
          }, 2000); // Tiempo en milisegundos
      } else {
          // Mostrar el mensaje de error
          mostrarMensajeDeError(data.message, mensajeContenedor);
      }
  }).fail(function() {
      mostrarMensajeDeError("Error al cargar el contenido", mensajeContenedor);
  });
}

function cargarFormularioActualizar(contactoId, contenedorAOcultar="container", contenedorAMostrar="formulario-actualizar") {
  // Ocultar la tabla y mostrar el formulario
  $("#"+contenedorAOcultar).hide();
  $("#"+contenedorAMostrar).show();

  // Cargar los datos del contacto
  $.post("BD/buscarPorIdBD.php", { 'id': contactoId }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
          $("#contacto-id").val(data.contacto.id);
          $("#nombre").val(data.contacto.nombre);
          $("#correo").val(data.contacto.email);
          $("#telefono").val(data.contacto.telefono);
          $("#servicio").val(data.contacto.servicio);
          $("#consulta").val(data.contacto.consulta);
      } else {
          alert("Error al cargar el contacto.");
          cancelarEdicion(contenedorAMostrar,contenedorAOcultar);
      }
  }).fail(function() {
      alert("Error al cargar el contacto.");
      cancelarEdicion(contenedorAMostrar,contenedorAOcultar);
  });
}
function cancelarEdicion(contenedorAOcultar="formulario-actualizar", contenedorAMostrar="actualizar-container") {
  // Ocultar el formulario y mostrar la tabla
  $("#"+contenedorAOcultar).hide();
  $("#"+contenedorAMostrar).show();
}

function actualizarContacto(urlDeRetorno="actualizar.php") {
  let id = $("#contacto-id").val();
  let nombre = $("#nombre").val().trim();
  let email = $("#correo").val().trim();
  let telefono = $("#telefono").val().trim();
  let servicio = $("#servicio").val();
  let consulta = $("#consulta").val().trim();


  if (nombre === "" || email === "" || telefono === "" || servicio === "" || consulta === "") {
      alert("Por favor, completa todos los campos.");
      return;
  }

  $.post("BD/actualizarPorIdBD.php", {
      'id': id,
      'nombre': nombre,
      'email': email,
      'telefono': telefono,
      'servicio': servicio,
      'consulta': consulta
  }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
        mostrarMensajeDeExito(data.message,'formulario-actualizar'); 
      } else {
          mostrarMensajeDeError(data.message,'formulario-actualizar');
      }
      setTimeout(function(){ cargarURL(urlDeRetorno,'menu-details',false);}, 2000);
  }).fail(function() {
      alert("Error al actualizar el contacto.");
  });
}

function eliminarItemPorId(id, urlDeRetorno="eliminar.php"){
  // Validar que el ID sea mayor a cero y que el usuario confirme la eliminación
  if (id <= 0 || !confirm("¿Estás seguro de que deseas eliminar este contacto?")) {
      return;
  }
  mostrarLoader(300); 
  $.post("BD/eliminarPorIdBD.php", {
      'id': id,
  }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
        mostrarMensajeDeExito(data.message,'container'); 
      } else {
          mostrarMensajeDeError(data.message,'container');
      }
      setTimeout(function(){ mostrarLoader(300); cargarURL(urlDeRetorno,'menu-details',false);}, 2000);
  }).fail(function() {
      alert("Error al eliminar el contacto.");
  });
}

// Función para vaciar un contenedor
function vaciarContenedor(contenedor) {
  $(`#${contenedor}`).html("");
}

// Función para mostrar un mensaje de éxito (temporal)
function mostrarMensajeDeExito(mensaje, contenedor) {
  $(`#${contenedor}`).html(`
      <div class="success">
          <h2>${mensaje}</h2>
      </div>
  `);
}

// Función para mostrar un mensaje de error (persistente)
function mostrarMensajeDeError(mensaje, contenedor) {
  $(`#${contenedor}`).html(`
      <div class="error">
          <h2>${mensaje}</h2>
      </div>
  `);
}
function limpiarMensajesDeError() {
    $(".error-message").remove();
}

function mostrarTextoDeError(mensaje, campoId) {
    const input = $(`#${campoId}`);
    if (input.next(".error-message").length === 0) {
        input.after(`<div class="error-message error">${mensaje}</div>`);
    }
}

// Función para mostrar el loader
function mostrarLoader(milisegundos = 1000) {
  document.getElementById("loader").style.display = "flex";
  setTimeout(() => document.getElementById("loader").style.display = "none", milisegundos);

}




