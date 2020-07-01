<?php 
    require_once 'funciones.php';
    
    //Comprobamos que el usuario es gestor o al menos, es el creador de la biblioteca para poder modificarla.
    $id_recurso = $_POST['id_recurso'];
    $id_seccion = $_POST['id_seccion'];

    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);
    
    $id_biblioteca = cargarDatosSeccion($id_seccion)['datos']['id_biblioteca'];
    $id_autor_biblioteca = cargarDatosBiblioteca($id_biblioteca)['datos']['id_autor'];
    $nombre_autor_biblioteca = obtenerNombreUsuario($id_autor_biblioteca);

    if ($es_gestor || $nombre_autor_biblioteca == $usuario ){
        eliminarRecurso( $id_recurso );
        echo 1;
    }
    else echo 0;
    
?>
