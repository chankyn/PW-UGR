<?php 
    require_once 'funciones.php';
    
    //Comprobamos que el usuario es gestor o al menos, es el creador de la biblioteca para poder modificar la sección.
    $id_recurso = $_POST['id_recurso'];
    $id_biblioteca = $_POST['id_biblioteca'];

    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);
    
    $id_autor_biblioteca = cargarDatosBiblioteca($id_biblioteca)['datos']['id_autor'];
    $nombre_autor_biblioteca = obtenerNombreUsuario($id_autor_biblioteca);

    if ($es_gestor || $nombre_autor_biblioteca == $usuario ){
        $nombre = $_POST["nombre"];
        $nombre_autor = $_POST["autor"];
        if (existeRecurso($id_recurso,$nombre)){
            echo 1;
        }elseif (!existe_usuario($nombre_autor)){
            echo 2;
        }else{
            $id_autor = obtenerUsuario($nombre_autor)["datos"]["id_usuario"];
            $url_imagen = $_POST["url_imagen"];
            $id_seccion = $_POST["id_seccion"];
            $descripcion = $_POST["descripcion"];
            modificarRecurso($id_recurso,$url_imagen,$nombre,$id_autor,$id_seccion,$descripcion);
            echo 3;
        }
    }
    else echo 0;
    
?>
