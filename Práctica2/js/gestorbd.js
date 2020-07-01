$(function () {
    /* Hace una llamada al servidor para permitir el logout del usuario. A continuación, recarga la página.*/
    $("#logout").click(function(){
        $.get("logout.php").done(function(data){
            location = "index.php";
        });
    });
    /* Crea los botones (1,2,3,...) para dividir los recursos en un grid de 3x3. */
    $("#data-nav").ready(function(){
        let recursos_totales = $("#recursos_totales").val();
        let contador = 0;
        for (let i = 0; i < recursos_totales; i = i+9){
            $("#data-nav").append($("<span class='link-sub margin-right-05' onclick='cargar_recursos("+contador+")'></span>").text(contador+1));
            contador++;
        }
    });
    $("#siguiente").click(function(){
        siguiente();
    });
    $("#anterior").click(function(){
        anterior();
    });
    $("#btnNuevoUsuario").click(function(){
        insertarUsuario();
    });
    /* Se ejecuta la función mientras se va escribiendo texto. */
    $("#buscar").keyup(function(){
        buscar_usuario();
    });
    /* Se ejecuta la función cuando perdemos el focus del elemento. */
    $(".cargar_datos_usuario").blur(function(){
        cargar_datos_usuario();
    });
    $("#btnModificarUsuario").click(function(){
        modificarUsuario();
    });
    $("#btnBorrarUsuario").click(function(){
        borrarUsuario();
    });
    $("#cargar_imagenes_usuario").click(function(){
        cargar_imagenes_usuario()
    });
    $("#upload").click(function(){
        subir_imagen();
    });
    $("#btnNegacion").click(function(){
        history.back();
    });
    $("#seccion").change(function(){
        cargarSeccion($(this).val());
    });
    $("#seccion_recurso").change(function(){
        cargarRecursos($(this).val());
    });
    $("#recursos").change(function(){
        cargarDatosRecurso($(this).val());
    });

    if( $("#recursos").val() !== null)
        cargarDatosRecurso($("#recursos").val());
    
    /* Llamada ajax al servidor para ejecutar el borrado de una biblioteca. */
    $("#btnBorrar").click(function(){
        $.get("borrarbd.php",{borrar: true, id: $.urlParam("id")}).done(function(data){
            if (data === 0)
                crearVentanaInformacion("id_biblio_invalid");
            else
                location.href = "/~pw26050281/bdII/";
        });
    });

    $("#btnEditarBD").click(function(){
        editarBiblioteca();
    });

    $("#btnModificarSeccion").click(function(){
        editarSeccion();
    });
    $("#btnEliminarSeccion").click(function(){
        borrarSeccion();
    });
    $("#btnModificarRecurso").click(function(){
        editarRecurso();
    });
    $("#btnEliminarRecurso").click(function(){
        borrarRecurso();
    });
    $("#btnCrearBiblioteca").click(function(){
        crearBiblioteca();
    });
    $("#btnIniciarSesion").click(function(){
        mostrar_iniciar_sesion();
    });
    $("#btnRegistro").click(function(){
        mostrar_registro();
    });
    $("#btnCrearSeccion").click(function(){
        crearSeccion();
    });
    $("#btnCrearRecurso").click(function(){
        crearRecurso();
    });
    $("#profile").click(function(){
        mostrar_perfil_usuario();
    });
    /* Se ejecuta la función cuando el ratón pasa por encima del elemento. */
    $(".recursos_user").mouseover(function(){
        cargar_recursos_usuario($(this).attr("href").substr($(this).attr("href").lastIndexOf("=")+1));
    });
    
    //Devuelve el valor del parámetro perteneciente a la url que le pasemos como argumento.
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if(results != null)
        return results[1] || 0;
    }
    //Es necesario esperar un poco de tiempo ya que el evento scroll hace más de una llamada a la vez.
    var delay;
    $("#bscroll").scroll(function(){
        if ( delay ) clearTimeout(delay);
        delay = setTimeout(function(){
            cargarMasBibliotecas();
        }, 50);
    });
   
    /* Dialog personalizable, usado para la mayoría de mensajes de error o información al usuario -> Jquery UI */
    $("#errorDialog").dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        title: "Error",
        width: "30%",
        minHeight: 0,
        
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); $(this).css("maxHeight", 400);   },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                if (getVariableURL('?','error')){
                    //Quitamos de la url el error para que no vuelva a saltar la función.
                    let cadena_a_borrar = '?error='+$.urlParam("error");
                    let url_search = location.search;
                    url_search = url_search.replace(cadena_a_borrar, '');
                    location.search = url_search;
                }
            }
        }
    });
    /* Si se encuentra en la url un error, lanzamos un mensaje personalizado por cada error. */
    if (getVariableURL('?','error')){
        crearVentanaInformacion($.urlParam("error"));
    }
    
});
/* Función que recibe una id de biblioteca y muestra un mensaje al usuario con los recursos que ha creado en dicha biblioteca. */
function cargar_recursos_usuario(id){
    $.ajax({
        url:"cargar_recursos_usuario_por_biblioteca.php",
        type:"POST",
        data: {id_biblioteca: id },
        success:function(data){
            if (data === 0)
                crearVentanaInformacion("existe_usuario")
            else if (data.length > 0 ){
                $("#errorDialog").dialog( "option", "title", "Recursos subidos por el usuario" );
                $("#errorDialog").prev().removeClass("ui-state-error");
                $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
                $("#errorDialog").dialog( "option", "buttons", 
                {
                    "Aceptar": function()
                    {
                        $(this).dialog('close');
                    }
                });
                $("#errorDialog").empty();
                let contenido = '<section><ul>';
                for (let i=0;i<data.length;i++){
                    contenido+='<li>'+data[i]+'</li>';
                }
                contenido+='</ul></section>';
                $("#errorDialog").append(contenido);
                $("#errorDialog").dialog("open");
            }
        },dataType: "json"
    });
}

/*Valida los datos introducidos por el usuario para crear una nueva biblioteca y los envía al servidor mediante una llamada ajax.*/
function crearBiblioteca(){
    let nombre = $("#nombre").val();
    let imagen = $("#img_cargada").attr("src");
    let autor = $("#autor").val();
    let fuente = $("#fuente").val();
    let descripcion = $("#text_desc").val();
    if (imagen == ""){
        crearVentanaInformacion("escoge_imagen");
    }else
        if (validarDatosBD(nombre,autor,fuente,descripcion,true)){
            $.ajax({
                url:"crearbd.php",
                type:"POST",
                data: {insertar: true, nombre: nombre, autor: autor,url_imagen:imagen, fuente: fuente, descripcion: descripcion },
                success:function(data){
                    if (data === 0)
                        crearVentanaInformacion("error_autor");
                    else if (data === 1)
                        crearVentanaInformacion("nombre_b_en_uso");
                    else
                        alert("Biblioteca "+nombre+" creada con éxito.");
                },
                dataType: "json"
            });
        }
        else crearVentanaInformacion("validacion");
}
/*Valida los datos introducidos por el usuario para crear una nueva sección y los envía al servidor mediante una llamada ajax. */
function crearSeccion(){
    let nombre = $("#nombre").val();
    let imagen = $("#img_cargada").attr("src");
    let autor = $("#autor").val();
    let descripcion = $("#text_desc").val();
    if (imagen == ""){
        crearVentanaInformacion("escoge_imagen");
    }else
        if (validarDatosSeccion(nombre,autor,descripcion,true)){
            $.ajax({
                url:"altaseccion.php",
                type:"POST",
                data: {insertar: true, id_biblioteca: $.urlParam("id"),nombre: nombre, autor: autor,url_imagen:imagen, descripcion: descripcion },
                success:function(data){
                    if (data === 0)
                        crearVentanaInformacion("error_autor");
                    else if (data === 1)
                        crearVentanaInformacion("nombre_s_en_uso");
                    else{
                        alert("Sección "+nombre+" creada con éxito.");
                        location.reload();
                    }
                },dataType: "json"
            });
        }
        else crearVentanaInformacion("validacion");
}
/*Valida los datos introducidos por el usuario para crear un nuevo recurso y los envía al servidor mediante una llamada ajax. */
function crearRecurso(){
    let nombre = $("#nombre").val();
    let imagen = $("#img_cargada").attr("src");
    let autor = $("#autor").val();
    let descripcion = $("#text_desc").val();
    let id_seccion = $("#sec").val();
    if (imagen == ""){
        crearVentanaInformacion("escoge_imagen");
    }else
        if (validarDatosSeccion(nombre,autor,descripcion,true)){
            $.ajax({
                url:"altarecurso.php",
                type:"POST",
                data: {insertar: true, id_biblioteca: $.urlParam("id"),id_seccion: id_seccion, nombre: nombre, autor: autor,url_imagen:imagen, descripcion: descripcion },
                success:function(data){
                    if (data === 0)
                        crearVentanaInformacion("error_autor");
                    else if (data === 1)
                        crearVentanaInformacion("nombre_r_en_uso");
                    else{
                        alert("Recurso "+nombre+" creado con éxito.");
                        location.reload();
                    }
                },dataType: "json"
            });
        }
        else crearVentanaInformacion("validacion");
}

/* Crea una ventana con información útil para el usuario. P.e. si ha ocurrido un error o se ha completado una tarea. */
function crearVentanaInformacion(tipo_error,error,reload){
    tipo_error = typeof tipo_error !== 'undefined' ?  tipo_error : tipo_error = $.urlParam("error");
    error = typeof error !== 'undefined' ?  error : error = true;
    reload = typeof reload !== 'undefined' ?  reload : reload = false;
    let mensaje = "";
    switch(tipo_error){
        case "login":
            mensaje = "Usuario o contraseña no válidos. Vuelva a intentarlo.";
        break;
        case "id_biblio_invalid":
            mensaje = "La biblioteca indicada no existe en nuestra BD. Vuelva a intentarlo.";
        break;
        case "id_seccion_invalid":
            mensaje = "La sección indicada no existe en nuestra BD. Vuelva a intentarlo.";
        break;
        case "datos_modificados":
            mensaje = "Los datos se han modificado con éxito.";
        break;
        case "error_autor":
            mensaje = "El autor no es correcto.";
        break;
        case "seccion_vacia":
            mensaje = "Esta sección no tiene recursos disponibles.";
        break;
        case "nombre_b_en_uso":
            mensaje = "El nombre de la biblioteca no es correcto. Ya está en uso.";
        break;
        case "nombre_s_en_uso":
            mensaje = "El nombre de la sección no es correcto. Ya está en uso.";
        break;
        case "nombre_r_en_uso":
            mensaje = "El nombre del recurso no es correcto. Ya está en uso.";
        break;
        case "validacion":
            mensaje = "Hay algún error en la validación de campos. Vuelva a intentarlo de nuevo.";
        break;
        case "permisos":
            mensaje = "No tienes sufientes permisos.";
        break;
        case "existe_usuario":
            mensaje = "El usuario no existe. Vuelva a intentarlo.";
        break;
        case "privilegios":
            mensaje = "No tienes sufientes privilegios.";
        break;
        case "escoge_imagen":
            mensaje = "No ha seleccionado una imagen válida.";
        break;
        case "error_subida_imagen":
            mensaje = "Inicia sesión primero.";
        break;
        case "error_subida":
            mensaje = "Error al subir la imagen. Vuelva a intentarlo.";
        break;
        default:
            mensaje = "Error no reconocido.";
    }
    if (!error){
        $("#errorDialog").dialog( "option", "title", "Mensaje del sistema" );
        $("#errorDialog").prev().removeClass("ui-state-error");
        $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
    }
    else 
    {
        $("#errorDialog").prev().removeClass("ui-state-highlight");
        $("#errorDialog").prev().addClass("ui-state-error ui-corner-all");
    }
   
    if (reload){
        $("#errorDialog").dialog( "option", "buttons", 
        {
            "Aceptar": function()
            {
                $(this).dialog('close');
                location.reload();
            }
        });
    }else{
        $("#errorDialog").dialog( "option", "buttons", {
            "Aceptar": function()
                {
                    $(this).dialog('close');
                    //Cambiamos la url.
                    if (getVariableURL('?','error')){
                        //Quitamos de la url el error para que no vuelva a saltar la función.
                        let cadena_a_borrar = '?error='+$.urlParam("error");
                        let url_search = location.search;
                        url_search = url_search.replace(cadena_a_borrar, '');
                        location.search = url_search;
                    }
                }
        });
    }
    $("#errorDialog").empty();
    $("#errorDialog").append('<span>'+mensaje+'</span>');
    $("#errorDialog").dialog("open");
}

/* En un principio se muestran 4 bibliotecas. Esta función carga más bibliotecas cuando el usuario hace scroll en la lista y quedan sin cargar. */
function cargarMasBibliotecas(){
    let elementos_ya_cargados = $("#bscroll strong").length;
    $.ajax({
        url:"cargar_bibliotecas.php",
        type:"POST",
        data: {elem_actuales: elementos_ya_cargados},
        success:function(data){
            if (data == 0){
                $("#bscroll").off(); //Desactivamos el evento de scroll para que no haga mas llamadas al servidor.
            }
            else
            {
                console.log("Carga mas");
                let seccion = $("#bscroll");
                let contenido;
                for( var i = 0; i < data[0].length; i++){
                    if (data[1] == true)
                        contenido = $('<article class="flex double-line-height"><a class="col-2" onmouseover="cargar_recursos_usuario('+data[0][i].datos.id_biblioteca+')" href="bd.php?id='+data[0][i].datos.id_biblioteca+'"><img class="img-miniatura" alt="Miniatura '+data[0][i].datos.nombre+'" src="'+data[0][i].datos.url_imagen+'"/></a><article class="col-2"><a class="link-title" href="bd.php?id='+data[0][i].datos.id_biblioteca+'"><strong>'+data[0][i].datos.nombre+'</strong></a><aside><a class="link-sub" href="borrarbd.php?id='+data[0][i].datos.id_biblioteca+'">Borrar </a><a class="link-sub" href="editarbd.php?id='+data[0][i].datos.id_biblioteca+'">Edici&oacute;n</a></aside></article></article>');
                    else
                        contenido = $('<article class="flex double-line-height"><a class="col-2" onmouseover="cargar_recursos_usuario('+data[0][i].datos.id_biblioteca+')" href="bd.php?id='+data[0][i].datos.id_biblioteca+'"><img class="img-miniatura" alt="Miniatura '+data[0][i].datos.nombre+'" src="'+data[0][i].datos.url_imagen+'"/></a><article class="col-2"><a class="link-title" href="bd.php?id='+data[0][i].datos.id_biblioteca+'"><strong>'+data[0][i].datos.nombre+'</strong></a>');
            
                    seccion.append(contenido);
                }
            }
        },
        dataType:"json"
    });
}
/* Carga los datos de la sección con id = id_seccion mediante una llamada ajax. */
function cargarSeccion(id_seccion){
    $.ajax({
        url:"cargar_seccion.php",
        type:"POST",
        data: {id_seccion: id_seccion},
        success:function(data){
            $(".img-miniatura").attr("src",data[0].datos.url_imagen);
            $("#nombre").val(data[0].datos.nombre);
            $("#autor").val(data[1]);
            $("#text_desc").val(data[0].datos.descripcion);
        },
        dataType:"json"
    });
}
/* Carga los recursos de la sección con id_seccion = id_seccion mediante una llamada ajax. */
function cargarRecursos(id_seccion){
    $.ajax({
        url:"cargar_recursos.php",
        type:"POST",
        data: {id_seccion: id_seccion,seccion: true},
        success:function(data){
            $("#recursos").empty();
            if (data[0] !== 1){
                for (let i = 0; i < data[0].length; i++){
                    $("#recursos").append('<option value="'+data[0][i].datos.id_recurso+'">'+data[0][i].datos.nombre+'</option>');
                }
                $(".img-miniatura").attr("src",data[0][0].datos.url_imagen);
                $("#nombre").val(data[0][0].datos.nombre);
                $("#autor").val(data[1]);
                $("#nueva_s").find('option:selected').removeAttr("selected");
                
                $("#nueva_s option[value="+ id_seccion +"]").attr("selected",true);
                $("#text_desc").val(data[0][0].datos.descripcion);
                
            }else{
                crearVentanaInformacion("seccion_vacia",false);
                $("#nombre").val("");
                $("#autor").val("");
            }
        },
        dataType:"json"
    });
}
/* Carga el recurso id = id_recurso mediante una llamada ajax. */
function cargarDatosRecurso(id_recurso){
    
    $.ajax({
        url:"cargar_recursos.php",
        type:"POST",
        data: {id_recurso: id_recurso,datos_recurso: true},
        success:function(data){
            $(".img-miniatura").attr("src",data[0].datos.url_imagen);
            $("#nombre").val(data[0].datos.nombre);
            $("#autor").val(data[1]);
            $("#nueva_s option[value="+ data[0].datos.id_seccion +"]").attr("selected",true);
            $("#text_desc").val(data[0].datos.descripcion);
        },
        dataType:"json"
    });
}
/* Valida los datos introducidos por el usuario para modificar una biblioteca y hace una llamada ajax al servidor para procesar la edición. */
function editarBiblioteca(){
    let nombre = $("#nombre").val();
    let autor = $("#autor").val();
    let fuente = $("#fuente").val();
    let descripcion = $("#text_desc").val();
    let url_imagen = $(".img-miniatura").attr("src");
    
    if (validarDatosBD(nombre,autor,fuente,descripcion)){
        $.ajax({
            url:"modificarBD.php",
            type:"POST",
            data: { id: $.urlParam("id"),nombre: nombre,autor: autor,fuente: fuente,descripcion: descripcion,url_imagen: url_imagen},
            success:function(data){
                if (data === 0){
                    crearVentanaInformacion("privilegios");
                }else if (data === 1){
                    crearVentanaInformacion("nombre_b_en_uso");
                }else if (data === 2){
                    crearVentanaInformacion("error_autor");
                }else{
                    $("#nombre").val(data[0].datos.nombre)
                    $("#autor").val(data[1]);
                    $("#fuente").val(data[0].datos.fuente);
                    $("#text_desc").val(data[0].datos.descripcion);
                    $(".img-miniatura").attr("src",data[0].datos.url_imagen);
                    $(".title h1").text("Biblioteca "+data[0].datos.nombre);
                    $(".logo img").attr("src",data[0].datos.url_imagen);
                    crearVentanaInformacion("datos_modificados",false);
                }
            },
            dataType:"json"
        });
    }
    else crearVentanaInformacion("validacion");
}
/* Valida los datos introducidos por el usuario para modificar una sección y hace una llamada ajax al servidor para procesar la edición. */
function editarSeccion(){
    let nombre = $("#nombre").val();
    let autor = $("#autor").val();
    let descripcion = $("#text_desc").val();
    let url_imagen = $(".img-miniatura").attr("src");
    let id_seccion = $("#seccion").val();
    if (validarDatosSeccion(nombre,autor,descripcion)){

        $.ajax({
            url:"modificarSeccion.php",
            type:"POST",
            data: { id_seccion: id_seccion,nombre: nombre,autor: autor, id_biblioteca: $.urlParam("id"), descripcion: descripcion, url_imagen: url_imagen},
            success:function(data){
                if (data === 0){
                    crearVentanaInformacion("privilegios");
                }else if (data === 1){
                    crearVentanaInformacion("nombre_s_en_uso",false);
                }else if (data === 2){
                    crearVentanaInformacion("error_autor");
                }else{
                    $("#nombre").val(data[0].datos.nombre);
                    $("#autor").val(data[1]);
                    $("#text_desc").val(data[0].datos.descripcion);
                    $(".img-miniatura").attr("src",data[0].datos.url_imagen);
                    $("#seccion").empty();$("nav ul").empty();
                    for(let i=0;i<data[2].length;i++){
                        $("#seccion").append('<option value="'+data[2][i].datos.id_seccion+'">'+data[2][i].datos.nombre+'</option>');
                        $("nav ul").append('<li><a class="link-sub" href="recursosseccion.php?id='+data[2][i].datos.id_seccion+'">'+data[2][i].datos.nombre+'</a></li>');
                    };
                    $("#seccion option[value="+ id_seccion +"]").attr("selected",true);

                    crearVentanaInformacion("datos_modificados",false);
                }
            },
            dataType:"json"
        });
    }
    else crearVentanaInformacion("validacion");
}
/* Pide confirmación al usuario a la hora de borrar una sección y en caso afirmativo, envía una petición ajax al servidor. */
function borrarSeccion(){
    let nombre_seccion = $("#nombre").val();
    let confirmado = confirm("¿Estás seguro de eliminar la sección: "+nombre_seccion+"?");
    if (confirmado){
        let id_seccion = $("#seccion").val();
        $.ajax({
            url:"eliminarSeccion.php",
            type:"POST",
            data: { id_seccion: id_seccion},
            success:function(data){
                if (data === 0){
                    crearVentanaInformacion("privilegios");
                }else{
                    alert("Se ha eliminado la sección "+nombre_seccion+" correctamente.");
                    location.reload();
                }
            },dataType: "json"
        });
    }
}
/* Pide confirmación al usuario a la hora de borrar un recurso y en caso afirmativo, envía una petición ajax al servidor. */
function borrarRecurso(){
    let nombre_recurso = $("#recursos option:selected").text();// .val() tiene el id del recurso
    let confirmado = confirm("¿Estás seguro de eliminar el recurso: "+nombre_recurso+"?");
    if (confirmado){
        let id_recurso = $("#recursos").val();
        let id_seccion = $("#seccion_recurso").val();
        $.ajax({
            url:"eliminarRecurso.php",
            type:"POST",
            data: { id_recurso: id_recurso, id_seccion: id_seccion},
            success:function(data){
                if (data === 0){
                    crearVentanaInformacion("privilegios");
                }else{
                    alert("Se ha eliminado el recurso "+nombre_recurso+" correctamente.");
                    location.reload();
                }
            },dataType: "json"
        });
    } 
}
/* Valida los datos introducidos por el usuario para modificar un recurso y hace una llamada ajax al servidor para procesar la edición. */
function editarRecurso(){
    let id_recurso = $("#recursos").val();
    
    let nombre = $("#nombre").val();
    let autor = $("#autor").val();
    let descripcion = $("#text_desc").val();
    let nueva_s = $("#nueva_s").val();
    let url_imagen = $(".img-miniatura").attr("src");

    if (validarDatosSeccion(nombre,autor,descripcion)){
        $.ajax({
            url:"modificarRecurso.php",
            type:"POST",
            data: { id_recurso: id_recurso,nombre: nombre,autor: autor, id_biblioteca: $.urlParam("id"), descripcion: descripcion, url_imagen: url_imagen, id_seccion: nueva_s},
            success:function(data){
                if (data === 0){
                    crearVentanaInformacion("privilegios");
                }else if (data === 1){
                    crearVentanaInformacion("nombre_r_en_uso",false);
                }else if (data === 2){
                    crearVentanaInformacion("error_autor");
                }else{
                    crearVentanaInformacion("datos_modificados",false,true);
                }
            },
            dataType:"json"
        });
    }
    else crearVentanaInformacion("validacion");
}
/* Función para validar campos. */
function validarCampo(campo,longitud_min,longitud_max,vacio){
    if (campo !== "" ){ //Si el campo no está vacío...
        if (campo.length < longitud_min || campo.length > longitud_max ) //Comprobamos la longitud
            return false;
        if (!vacio){ //Si no puede ser un campo vacío...
            let regex = /^([A-Za-z0-9_\-.*])+$/; //Solo se acepta alfanuméricso y símbolos corrientes
            return regex.test(campo);
        }else return true;
    }else{//Si el campo está vacío..
        if (vacio) //y puede serlo, devuelve true, en caso contrario devuelve false.
            return true;
        else return false;
    } 
}
/* Comprueba que ambas contraseñas sean iguales. */
function validarContrasena(pass,pass2){
    if (pass === pass2)
        return true;
    else return false;
}
/* Valida los datos necesarios para crear un registro de usuario. Si algún campo falla, se muestra un mensaje al usuario y se le marca de color rojo. */
function validarDatosUsuario(nombre,pass,pass2,apellidos,direccion,modificar){
    let valido = true;
    let valido_pass1 = true;
    let valido_pass2 = true;

    if (!validarCampo(nombre.val(),4,30,false)){
        valido = false;
        nombre.css('borderColor','red'); 
        nombre.attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
        nombre.tooltip();
    }else{
        nombre.css('borderColor',''); 
        nombre.attr('title','');
    }

    if (!modificar){
        if (!validarCampo(pass.val(),4,30,false)){
            valido_pass1 = false;valido = false;
            pass.css('borderColor','red');
            pass.attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            pass.tooltip();
        }else{
            pass.css('borderColor','');
            pass.attr('title','');
        } 
    
        if (!validarCampo(pass2.val(),4,30,false)){
            valido_pass2 = false;valido = false;
            pass2.css('borderColor','red');
            pass2.attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            pass2.tooltip();
        }else{
            pass2.css('borderColor','');
            pass2.attr('title','');
        }
    }else{
        if (!validarCampo(pass.val(),4,30,true)){
            valido_pass1 = false;valido = false;
            pass.css('borderColor','red');
            pass.attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            pass.tooltip();
        }else{
            pass.css('borderColor','');
            pass.attr('title','');
        } 
    
        if (!validarCampo(pass2.val(),4,30,true)){
            valido_pass2 = false;valido = false;
            pass2.css('borderColor','red');
            pass2.attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            pass2.tooltip();
        }else{
            pass2.css('borderColor','');
            pass2.attr('title','');
        }
    }
    if (valido_pass1 && valido_pass2){
        if (!validarContrasena(pass.val(),pass2.val())){
            valido = false;
            pass.css('borderColor','red');
            pass2.css('borderColor','red');
            pass.attr('title','¡Las contraseñas no coinciden!');
            pass2.attr('title','¡Las contraseñas no coinciden!');
            pass.tooltip();pass2.tooltip();
        }else {
            pass.css('borderColor','');
            pass2.css('borderColor','')
            pass.attr('title','');
            pass2.attr('title','');
        };
    }
    
    if (!validarCampo(apellidos,0,50,true)){
        valido = false; 
        $("#apellidos_user").css('borderColor','red');
        $("#apellidos_user").attr('title','Debe de tener una longitud máxima de 30 caracteres');
        $("#apellidos_user").tooltip();
    } else{
        $("#apellidos_user").css('borderColor','');
        $("#apellidos_user").attr('title','');
    } 
    
    if (!validarCampo(direccion,0,50,true)){
        valido = false; 
        $("#direccion_user").css('borderColor','red');
        $("#direccion_user").attr('title','Debe de tener una longitud máxima de 50 caracteres');
        $("#direccion_user").tooltip();
    }else{
        $("#direccion_user").css('borderColor','');
        $("#direccion_user").attr('title','');
    } 
    return valido;
}
/* Valida los datos necesarios para crear un registro de biblioteca. Si algún campo falla, se muestra un mensaje al usuario y se le marca de color rojo. */
function validarDatosBD(nombre,autor,fuente,descripcion,insertar){
    let valido = true;
    insertar = typeof insertar !== 'undefined' ?  insertar : insertar = false;
    if(insertar){
        if (!validarCampo(nombre,4,30,false)){
            valido = false;
            $("#nombre").css('borderColor','red'); 
            $("#nombre").attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            $("#nombre").tooltip();
        }else{
            $("#nombre").css('borderColor',''); 
            $("#nombre").attr('title','');
        }
    }else{
        if (!validarCampo(nombre,4,30,true)){
            valido = false;
            $("#nombre").css('borderColor','red'); 
        }else{
            $("#nombre").css('borderColor','');
        }
    }
    if (!validarCampo(autor,4,30,false)){
        valido = false;
        $("#autor").css('borderColor','red'); 
    }else $("#autor").css('borderColor','');

    if (!validarCampo(fuente,0,30,true)){
        valido = false;
        $("#fuente").css('borderColor','red'); 
    }else $("#fuente").css('borderColor','');
    
    if (!validarCampo(descripcion,0,200,true)){
        valido = false;
        $("#text_desc").css('borderColor','red'); 
    }else $("#text_desc").css('borderColor','');
    

    return valido;
}
/* Valida los datos necesarios para crear un registro de sección. Si algún campo falla, se muestra un mensaje al usuario y se le marca de color rojo. */
function validarDatosSeccion(nombre,autor,descripcion,insertar){
    let valido = true;
    insertar = typeof insertar !== 'undefined' ?  insertar : insertar = false;
    if(insertar){
        if (!validarCampo(nombre,4,30,false)){
            valido = false;
            $("#nombre").css('borderColor','red'); 
            $("#nombre").attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
            $("#nombre").tooltip();
        }else{
            $("#nombre").css('borderColor',''); 
            $("#nombre").attr('title','');
        }
    }else{
        if (!validarCampo(nombre,4,30,true)){
            valido = false;
            $("#nombre").css('borderColor','red'); 
        }else{
            $("#nombre").css('borderColor','');
        }
    }
    if (!validarCampo(autor,4,30,false)){
        valido = false;
        $("#autor").css('borderColor','red'); 
    }else $("#autor").css('borderColor','');

    if (!validarCampo(descripcion,0,200,true)){
        valido = false;
        $("#text_desc").css('borderColor','red'); 
    }else $("#text_desc").css('borderColor','');

    return valido;
}
/* Valida los datos introducidos por el usuario para modificar un usuario y hace una petición ajax al servidor. */
function modificarUsuario(){
    let nombre = $("#buscar");
    let pass = $("#pass");
    let pass2 = $("#pass2");
    let apellidos = $("#apellidos");
    let direccion = $("#direccion");
    let tipo = $("#tipo").val();

    if (validarDatosUsuario(nombre,pass,pass2,apellidos,direccion,true)){
        $.ajax({
            url:"modificargestor.php",
            type:"POST",
            data: { nombre: nombre.val(), pass: pass.val(), apellidos: apellidos.val(), direccion: direccion.val(), tipo: tipo },
            success:function(data){
                if (data == 0){
                    crearVentanaInformacion("permisos");
                }else if(data == 1){
                    crearVentanaInformacion("existe_usuario");
                }
                else alert(data);
                
            },
        });
    }
    else crearVentanaInformacion("validacion");
}
/* Valida los datos introducidos por el usuario para crear un usuario y hace una petición ajax al servidor. */
function insertarUsuario(){
    let nombre = $("#nombre_user");
    let pass = $("#pass_user");
    let pass2 = $("#pass2_user")
    let apellidos = $("#apellidos_user")
    let direccion = $("#direccion_user");
    let tipo = $("#tipo").val();
    
    if (validarDatosUsuario(nombre,pass,pass2,apellidos,direccion,false)){
        $.ajax({
            url:"altagestor.php",
            type:"POST",
            data: {insertar: true, nombre: nombre.val(), pass: pass.val(), apellidos: apellidos.val(), direccion: direccion.val(), tipo: tipo },
            success:function(data){
                if (data === 0)
                    alert("Nombre de usuario "+nombre.val()+" en uso. Elige uno diferente. ");
                else
                    alert("Usuario "+nombre.val()+" añadido con éxito.");
            },dataType: "json"
        });
    }
    //else crearVentanaInformacion("validacion");
}
/* Hace una petición ajax al servidor para procesar el borrado de un usuario. */
function borrarUsuario(){
    let nombre = $("#buscar").val();

    $.ajax({
        url:"borrargestor.php",
        type:"POST",
        data: { nombre: nombre, borrar: true },
        success:function(data){
            if (data == 0){
                crearVentanaInformacion("permisos");
            }else if(data == 1){
                alert("El usuario "+nombre+" no existe.");
            }
            else{
                alert(data);
                location.reload();
            }
        },
    });
}
/* Carga los recursos correspondientes a cada pagina del grid 3x3. */
function cargar_recursos(pagina){
    let id_seccion = $("#id_seccion").val();
    $.ajax({
        url:"cargar_recursos.php",
        type:"POST",
        data: {id_seccion: id_seccion,fila_inicio: pagina*9, numero_filas: 9},
        success:function(data){
            let seccion = $(".grid-3x3");
            seccion.empty();
            for( var i = 0; i < data.length; i++){
                let contenido = $('<article><h2><a class="link-sub" href="recurso.php?id='+data[i].datos.id_recurso+'">'+data[i].datos.nombre+'</a></h2> <a href="recurso.php?id='+data[i].datos.id_recurso+'"><img class="img-pokemon-miniatura" src="'+data[i].datos.url_imagen+'" alt="Imagen recurso '+data[i].datos.id_recurso+'"/></a><p>Descripcion '+data[i].datos.nombre+'</p></article>');
                seccion.append(contenido);
            }
            
        },
        dataType:"json"
    });
}
/* Crea un datalist con los usuarios que coinciden con la cadena introducida por el usuario. */
function buscar_usuario(){
    let nombre = $("#buscar").val();
    $.ajax({
        url:"busqueda_usuario.php",
        type:"POST",
        data: {nombre: nombre},
        success:function(data){
            let datalist = $("#busqueda");
            datalist.empty();
            let nuevo;
            for (let i = 0; i < data.length; i++){
                nuevo = $("<option value="+data[i]+">");
                datalist.append(nuevo);
            }
        },
        dataType:"json"
    });
}
/* Valida los datos introducidos por el usuario y envía una petición al servidor para modificar los datos del usuario. */
function modificarUsuarioVentana(){
    let nombre = $("#user");
    let pass = $("#pass");
    let pass2 = $("#pass2");
    let apellidos = $("#apellidos");
    let direccion = $("#direccion");

    if (validarDatosUsuario(nombre,pass,pass2,apellidos,direccion,true)){
        
        $.ajax({
            url:"modificargestor.php",
            type:"POST",
            data: { permisos: true, nombre: nombre.val(), pass: pass.val(), apellidos: apellidos.val(), direccion: direccion.val()},
            success:function(data){
                if (data == 0){
                    alert("No tienes sufientes permisos.");
                }else if(data == 1){
                    alert("El usuario no existe.");
                }
                else alert(data);
            },
        });
    }
}
/* Permite la subida de ficheros al servidor mediante ajax. Cuando recibe el OK del servidor muestra la imagen subida. */
function subir_imagen(){
    var fd = new FormData();
    var files = $('#file')[0].files[0];
    
    fd.append('file',files);

    $.ajax({
        url: "upload.php",
        type: "POST",
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            if (response == 0)
                crearVentanaInformacion("permisos");
            else if (response == 1)
                crearVentanaInformacion("escoge_imagen");
            else if (response == 2)
                crearVentanaInformacion("error_subida");
            else{
                $("#img_cargada").attr("src",response); 
                $(".preview").show();
            }
        }
    });
}
/* Carga todas las imágenes subidas por el usuario que está conectado. */
function cargar_imagenes_usuario(){
    $.ajax({
        url:"cargar_imagenes_usuario.php",
        type:"POST",
        success:function(data){
            if (data === 0){
                crearVentanaInformacion("error_subida_imagen",false);
            }else{
                let num_imagenes;
                $("#errorDialog").dialog( "option", "title", "Imágenes del usuario" );
                $("#errorDialog").prev().removeClass("ui-state-error");
                $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
                $("#errorDialog").dialog( "option", "buttons", 
                {
                    "Confirmar": function()
                    {
                        $(this).dialog('close');
                        let imagen_seleccionada = $(".imgChked img");
                        if (imagen_seleccionada.attr("src") !== undefined){
                            $("#img_cargada").attr("src",imagen_seleccionada.attr("src"));
                            $(".preview").show();
                        }
                    }
                });
                
                $("#errorDialog").empty();

                for (num_imagenes=0;num_imagenes<data.length;num_imagenes++){
                    $("#errorDialog").append('<img class="seleccionable" name='+data[num_imagenes].datos.nombre_imagen+' src='+data[num_imagenes].datos.datos_imagen+' alt="Imagen usuario '+num_imagenes+'" width=150 height=100/>');
                }

                $("img.seleccionable").imgCheckbox({"radio": true});
                $("#errorDialog").dialog("open");
            }
        },dataType: "json"
    });
}
/* Crea una ventana para que el usuario pueda iniciar sesión. */
function mostrar_iniciar_sesion(){
    $("#errorDialog").dialog( "option", "title", "Inicio de sesión" );
    $("#errorDialog").prev().removeClass("ui-state-error");
    $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
    $("#errorDialog").dialog("option","minHeight", 280);
    $("#errorDialog").dialog( "option", "buttons", 
    {
        "Iniciar sesión": function()
        {
            if (validarUsuario())
                $('form#form_login').submit();
        },
        "Cancelar": function()
        {
            $(this).dialog('close');
        }
    });
    
    $("#errorDialog").empty();
    $("#errorDialog").append('<form method="POST" action="login.php" class="form-line" id="form_login" onsubmit="return validarUsuario()"><label for="usuario">Usuario</label><input type="text" required id="usuario" name="usuario" placeholder="Introduzca su usuario"/><label for="password">Contraseña</label><input type="password" required id="password" name="password" placeholder="Introduzca su contraseña"/><input type="hidden" id="location" name="location" value=""/></form>');
    
    $("#errorDialog").dialog("open");
        
}
/* Crea una ventana para que el usuario pueda registrarse en el sistema. */
function mostrar_registro(){
    $("#errorDialog").dialog( "option", "title", "Registro nuevo usuario" );
    $("#errorDialog").prev().removeClass("ui-state-error");
    $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
    $("#errorDialog").dialog( "option", "buttons", 
    {
        "Registrar": function()
        {
            insertarUsuario();
        },
        "Cancelar": function()
        {
            $(this).dialog('close');
        }
    });
    
    $("#errorDialog").empty();
    $("#errorDialog").append('<section class="col-1 center margin-top-2"><form class="form-line" action="#" method="post" name="form_alta_gestor"><section class="flex"></section><fieldset><label for="nombre">Nombre: </label><input type="text" required id="nombre_user"  placeholder="Introduzca su nombre"/><label for="pass">Contraseña: </label><input type="password" required id="pass_user"/><label for="pass2">Repetir contraseña: </label><input type="password" required id="pass2_user"/><label for="apellidos">Apellidos: </label><input type="text" id="apellidos_user" placeholder="Introduzca sus apellidos"/><label for="direccion">Direcci&oacute;n: </label><input type="text" id="direccion_user" placeholder="Introduzca su direcci&oacute;n"/><label for="tipo">Tipo de usuario: </label><select id="tipo"><option value=0>Registrado</option></select></fieldset></section></form></section>');
    
    $("#errorDialog").dialog("open");
}
/* Crea una ventana para que el usuario pueda editar sus datos personales. */
function mostrar_perfil_usuario(){
    $.ajax({
        url:"cargar_datos_usuario.php",
        type:"POST",
        success:function(data){
            if (data === 0){
                crearVentanaInformacion("error_subida_imagen",false);
            }else{
                $("#errorDialog").dialog( "option", "title", "Modificar datos de usuario" );
                $("#errorDialog").prev().removeClass("ui-state-error");
                $("#errorDialog").prev().addClass("ui-state-highlight ui-corner-all");
                $("#errorDialog").dialog( "option", "buttons", 
                {
                    "Modificar datos": function()
                    {
                        modificarUsuarioVentana();
                    },
                    "Cancelar": function()
                    {
                        $(this).dialog('close');
                    }
                });
                
                $("#errorDialog").empty();

                $("#errorDialog").append('<section class="col-1 center margin-top-2"><form class="form-line" action="#" method="post" name="form_editar_gestor"><section class="flex"><fieldset><label for="user">Nombre de usuario: </label><input type="text" readonly value="'+data.datos.nombre+'" id="user"/><label for="apellidos">Apellidos: </label><input type="text" id="apellidos"  value="'+data.datos.apellidos+'"/><label for="pass">Nueva contraseña: </label><input type="password" id="pass"/><label for="pass2">Repetir contraseña: </label><input type="password" id="pass2"/><label for="direccion">Direcci&oacute;n: </label><input type="text" id="direccion" value="'+data.datos.direccion+'"/></fieldset></section></form></section>');
                $("#errorDialog").dialog("open");
            }
        },dataType: "json"
    });
    
        
}
/* Carga los datos del usuario que se ha buscado. */
function cargar_datos_usuario(){
    let nombre = $("#buscar").val();
    $.ajax({
        url:"busqueda_usuario.php",
        type:"POST",
        data: {nombre: nombre,datos: true},
        success:function(data){
            $("#apellidos").val(data.datos.apellidos);
            $("#direccion").val(data.datos.direccion);
            $("#tipo option[value='"+data.datos.es_gestor+"']").attr("selected",true);
        },
        dataType:"json"
    });
}
/* Muestra el recurso siguiente al actual. */
function siguiente(){
    let id_recurso = parseInt($("#id_recurso").val())+1;
    $.ajax({
        url:"cargar_recursos.php",
        type:"POST",
        data: {id_recurso: id_recurso,data: true},
        success:function(data){
            $(".img-miniatura").attr("src",data[0].datos.url_imagen);
            $("#nombre").val(data[0].datos.nombre);
            $("#text_desc").val(data[0].datos.descripcion);
            $("#id_recurso").val(data[0].datos.id_recurso);
            $("#autor").val(data[1]);
            $("#seccion").val(data[2]);
            
        },
        dataType:"json"
    });
}
/* Muestra el recurso anterior al actual. */
function anterior(){
    let id_recurso = parseInt($("#id_recurso").val())-1;
    $.ajax({
        url:"cargar_recursos.php",
        type:"POST",
        data: {id_recurso: id_recurso,data: true},
        success:function(data){
            $(".img-miniatura").attr("src",data[0].datos.url_imagen);
            $("#nombre").val(data[0].datos.nombre);
            $("#text_desc").val(data[0].datos.descripcion);
            $("#id_recurso").val(data[0].datos.id_recurso);
            $("#autor").val(data[1]);
            $("#seccion").val(data[2]);
        },
        dataType:"json"
    });
}
/*Valida los datos introducidos el usuario para el inicio de sesión. */
function validarUsuario(){
    let usuario = $("#usuario").val();
    let contrasenia = $("#password").val();
    let valido = true;

    if (!validarCampo(usuario,4,30,false)){
        valido = false;
        $("#usuario").css('borderColor','red'); 
        $("#usuario").attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
        $("#usuario").tooltip();
    }else{
        $("#usuario").css('borderColor','');
        $("#nombre").attr('title','');
    }

    if (!validarCampo(contrasenia,4,30,false)){
        valido = false;
        $("#password").css('borderColor','red');
        $("#password").attr('title','Debe de tener una longitud entre 4 y 30 caracteres');
        $("#password").tooltip();
    }else{
        $("#password").css('borderColor','');
        $("#password").attr('');
    }

    $("#location").val(location.href);
    return valido;
}
/* Crea el mensaje de Bienvenido usuario. */
function crearMensajeUsuario(usuario){
    $("#nombre_usuario").text(usuario);
}
/* Devuelve el valor de la variable de la URL. P.e. index.php?id=1 devuelve 1 */
function getVariableURL(separador,variable){
    var url = window.location.href;
    var vars = url.split(separador);
    vars.shift();
  
    for (var i = 0;i < vars.length; i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable){
        return pair[1];
      }
    }
    return 0;
  }
