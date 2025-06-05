
function setActiveMenu(buttonId) {
    // Remover la clase activa de todos los botones
    $(".menu-button").removeClass("active");   
    // Añadir la clase activa al botón actual
    $(`#${buttonId}`).addClass("active");
}

function cargarURL(url,contenedor,efectoDeCarga=true, parametros={}, callback=null) {   
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
    // Ejecutar el callback si se proporciona y despues de cargar el contenido
    if (typeof callback === "function") {
      callback();
    }
  });

  $.get(...args).fail(function() {
    $(`#${contenedor}`).html(`
      <div class="error">
        <h2>Error al cargar el contenido</h2>
      </div>
    `);
  });
}

function validarFormularioYRegistrar(tablaBD, contenedorOrUrlDeRetorno, accion=null) {
    // Limpiar mensajes previos
    limpiarMensajesDeError();
    
    //Hacer distinción de la tabla(Empleados, Cargos y Profesiones) a la que se va a insertar para saber que campos validar
    let item = {};
    let esValido = true;

    if(tablaBD=="empleados"){
        // Obtener los valores de los campos del formulario en mayúsculas
        item["nombres"] = $("#nombre").val().trim().toUpperCase();
        item["apellido_paterno"] = $("#apellidoPaterno").val().trim().toUpperCase();
        item["apellido_materno"] = $("#apellidoMaterno").val().trim().toUpperCase();
        item["cargo_id"] = $("#cargo-actualizar").val();//Guarda el cargo_id
        item["profesion_id"] = $("#profesion-actualizar").val();//guarda el profesion_id

        // Validación del campo nombre
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["nombres"])) {
            mostrarTextoDeError("El nombre debe contener solo letras y tener entre 3 y 100 caracteres.", "nombre");
            esValido = false;
        }
        // Validación del campo apellido paterno
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["apellido_paterno"])) {
            mostrarTextoDeError("El apellido paterno debe contener solo letras y tener entre 3 y 100 caracteres.", "apellidoPaterno");
            esValido = false;
        }
        // Validación del campo apellido materno
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/.test(item["apellido_materno"])) {
            mostrarTextoDeError("El apellido materno debe contener solo letras y tener entre 3 y 100 caracteres.", "apellidoMaterno");
            esValido = false;
        }
        if (item['cargo_id'] === "" || item['cargo_id'] === null) {
            mostrarTextoDeError("Selecciona un cargo.", "cargo-actualizar");
            esValido = false;
        }
        if (item['profesion_id'] === "" || item['profesion_id'] === null) {
            mostrarTextoDeError("Selecciona una profesión.", "profesion-actualizar");
            esValido = false;
        }
    }
    else if(tablaBD=="cargos"){
        item['cargo'] = $("#cargo").val().toUpperCase();
        // Validación del campo cargo
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]{3,100}$/.test(item['cargo'])) {
             mostrarTextoDeError("El cargo debe contener solo letras, espacios o guiones medios y tener entre 3 y 100 caracteres.", "cargo");
            esValido = false;
        }
    }
    else if(tablaBD=="profesiones"){
        item['profesion'] = $("#profesion").val().toUpperCase();
        // Validación del campo profesion
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]{3,100}$/.test(item['profesion'])) {
            mostrarTextoDeError("La profesión debe contener solo letras, espacios o guiones medios y tener entre 3 y 100 caracteres.", "profesion");
            esValido = false;
        }
    }

    // Si todo es válido, se procede con la inserción
    if (esValido) {
      if(accion=="insert"){
        insertarNuevoItem(tablaBD,item,contenedorOrUrlDeRetorno);
      }
      else{
        item["id"] = $("#table-id").val();
        actualizarItem(tablaBD,item,contenedorOrUrlDeRetorno,accion);//Url de retorno
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

function buscarItemPorCampo(tablaBD, tablaContenedor, mensajeContenedor) {
  // Obtener columna y valor a buscar
  let columna = $("#columna").val();
  let valor = $("#busqueda").val().trim();

  if(tablaBD === "empleados"){
    // Obtener el valor del campo de búsqueda específico
    if (columna === "cargo" && $("#cargo").val() !== null) {
        valor = $("#cargo").val().trim();
    } else if (columna === "profesion" && $("#profesion").val() !== null) {
        valor = $("#profesion").val().trim();
    }
  }

  // Validar que los campos no estén vacíos
  if (columna === "" || valor === "") {
    // Limpiar el contenedor de mensajes
      vaciarContenedor(tablaContenedor);
      mostrarMensajeDeError("Por favor, completa todos los campos", mensajeContenedor);
      return;
  }
  // Limpiar tabla antes de la nueva búsqueda
  vaciarContenedor(tablaContenedor);
  // Realizar la petición AJAX
  $.post("BD/buscarRegistrosDeUnaTablaPorValorDeColumna.php", { 
      'tabla': tablaBD,
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

function cargarFormularioActualizar(tablaBD,tableID, contenedorAOcultar="container", contenedorAMostrar="formulario-actualizar") {
  // Ocultar la tabla y mostrar el formulario
  $("#"+contenedorAOcultar).hide();
  $("#"+contenedorAMostrar).show();

  // Cargar los datos del registro
  $.post("BD/buscarRegistroDeUnaTablaPorId.php", { 
      'tabla': tablaBD,
      'id':tableID,
  }, function(response){
      let data = JSON.parse(response);

      if (data.status === 'success') {
        $("#table-id").val(data.registroEncontrado.id);

        // Obtener los datos del registro dependiendo de la tabla
        if(tablaBD=="empleados"){
          // Obtener los datos del registro de empleados
          $("#nombre").val(data.registroEncontrado.nombres);
          $("#apellidoPaterno").val(data.registroEncontrado.apellido_paterno);
          $("#apellidoMaterno").val(data.registroEncontrado.apellido_materno);
          // Quiero seleccionar la opción del cargo y la profesión del registro encontrado en el select con id=cargo en la opción con el id=data.registroEncontrado.cargoId 
          $("#cargo-actualizar").val(data.registroEncontrado.cargoId);
          $("#profesion-actualizar").val(data.registroEncontrado.profesionId);
        }else{
          // Asignar el valor al resgistro encontrado de la columna(donde la columna es el nombre de la tabla en singular) determinada de la tabla al input de nombre
          //Verificar si la tabla termina en "es" o "s"
          if(tablaBD.endsWith("es")){
            $("#"+tablaBD.slice(0,-2)).val(data.registroEncontrado[tablaBD.slice(0,-2)]);
          }else{
            $("#"+tablaBD.slice(0,-1)).val(data.registroEncontrado[tablaBD.slice(0,-1)]);
          }
        }
      } else {
          alert("Error al cargar el registro.");
          cancelarEdicion(contenedorAMostrar,contenedorAOcultar);
      }
  }).fail(function() {
      alert("Error al cargar el registro.");
      cancelarEdicion(contenedorAMostrar,contenedorAOcultar);
  });
}
function cancelarEdicion(contenedorAOcultar="formulario-actualizar", contenedorAMostrar="vista-consultar") {
  // Ocultar el formulario y mostrar la tabla
  $("#"+contenedorAOcultar).hide();
  $("#"+contenedorAMostrar).show();
}

function actualizarItem(tablaBD, item,urlDeRetorno="actualizar.php", action=null) {

  $.post("BD/actualizarRegistroDeUnaTablaPorId.php", {
      'tabla':tablaBD,
      'item': item,
  }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
        mostrarMensajeDeExito(data.message,'formulario-actualizar'); 
      } else {
          mostrarMensajeDeError(data.message,'formulario-actualizar');
      }
      setTimeout(function(){ cargarURL(urlDeRetorno,'container',false,{
        tabla:tablaBD,
        accion : action
      });}, 2000);
  }).fail(function() {
      alert("Error al actualizar el contacto.");
  });
}

function eliminarItemPorId(tablaBD, id, urlDeRetorno="eliminar.php", action=null){
  // Validar que el ID sea mayor a cero y que el usuario confirme la eliminación
  if (id <= 0 || !confirm("¿Estás seguro de que deseas eliminar este registro?")) {
      return;
  }
  mostrarLoader(300); 
  $.post("BD/eliminarRegistroDeUnaTablaPorId.php", {
      'tabla':tablaBD,
      'id': id,
  }, function(response){
      let data = JSON.parse(response);
      if (data.status === 'success') {
        mostrarMensajeDeExito(data.message,'container'); 
      } else {
          mostrarMensajeDeError(data.message,'container');
      }
      setTimeout(function(){
        mostrarLoader(300); 
        cargarURL(urlDeRetorno,'container',false,{
          tabla:tablaBD,
          accion : action
        });
      }, 2000);
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



//Funcion para inicializar busqueda por columnas
function inicializarBusquedaPorColumna() {
  const vista = document.getElementById("vista-consultar");
  if (!vista) return; // No estás en consultar.php, salimos

  const columnaSelect = document.getElementById("columna");
  const busquedaInput = document.getElementById("busqueda");
  const busquedaCargo = document.getElementById("busqueda-cargo");
  const busquedaProfesion = document.getElementById("busqueda-profesion");


  if (!columnaSelect || !busquedaInput || !busquedaCargo || !busquedaProfesion) return;


  function actualizarCampos() {
    const seleccion = columnaSelect.value;

    busquedaCargo.style.display = "none";
    busquedaProfesion.style.display = "none";
    busquedaInput.style.display = "block";

    if (seleccion === "cargo") {
      busquedaCargo.style.display = "block";
      busquedaInput.style.display = "none";
    } else if (seleccion === "profesion") {
      busquedaProfesion.style.display = "block";
      busquedaInput.style.display = "none";
    }
    // Limpiar los campos de búsqueda
    busquedaInput.value = "";
    if (busquedaCargo.querySelector("select")) {
      busquedaCargo.querySelector("select").selectedIndex = 0;
    }
    if (busquedaProfesion.querySelector("select")) {
      busquedaProfesion.querySelector("select").selectedIndex = 0;
    }
  }

  columnaSelect.removeEventListener("change", actualizarCampos);
  columnaSelect.addEventListener("change", actualizarCampos);
  actualizarCampos();
}

// Función para cancelar la búsqueda y resetear el formulario
function cancelarBusqueda() {
  const columnaSelect = document.getElementById("columna");//ID de selector de columna de búsqueda
  const busquedaInput = document.getElementById("busqueda");//ID de input de búsqueda
  const busquedaCargo = document.getElementById("busqueda-cargo");// ID de contenedor de búsqueda de cargo(Aplica solo para empleados)
  const busquedaProfesion = document.getElementById("busqueda-profesion");// ID de contenedor de búsqueda de profesión(Aplica solo para empleados)

  // Restaurar valores por defecto
  columnaSelect.selectedIndex = 0;
  busquedaInput.value = "";

  //Verifica que los contenedores de búsqueda de cargo y profesión existan
  if(busquedaCargo && busquedaProfesion) {
    // Limpiar selects de cargo/profesión    
    if (busquedaCargo.querySelector("select")) {
      busquedaCargo.querySelector("select").selectedIndex = 0;
    }
    if (busquedaProfesion.querySelector("select")) {
      busquedaProfesion.querySelector("select").selectedIndex = 0;
    }
    // Ocultar selects de cargo/profesión y mostrar campo de texto
    busquedaCargo.style.display = "none";
    busquedaProfesion.style.display = "none";
}
  busquedaInput.style.display = "block";

  // Limpiar resultados y mensajes
  const tablaResultados = document.getElementById("tabla");
  const mensaje = document.getElementById("mensaje");
  if (tablaResultados) tablaResultados.innerHTML = "";
  if (mensaje) mensaje.innerHTML = "";
}
