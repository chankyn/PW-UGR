<?php 
    require_once 'funciones.php';
    
    //Comprobamos que el usuario es gestor o al menos, es el creador de la biblioteca para poder modificar la sección.
    $id_seccion = $_POST['id_seccion'];
    $id_biblioteca = $_POST['id_biblioteca'];
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);
    
    $datos_seccion = cargarDatosSeccion($id_seccion);
    $id_autor_biblioteca = cargarDatosBiblioteca($id_biblioteca)['datos']['id_autor'];
    $nombre_autor_biblioteca = obtenerNombreUsuario($id_autor_biblioteca);

    if ($es_gestor || $nombre_autor_biblioteca == $usuario ){
        $nombre = $_POST["nombre"];
        $nombre_autor = $_POST["autor"];
        if (existeSeccion($id_seccion,$nombre)){
            echo 1;
        }elseif (!existe_usuario($nombre_autor)){
            echo 2;
        }else{
            $id_autor = obtenerUsuario($nombre_autor)["datos"]["id_usuario"];
            $url_imagen = $_POST["url_imagen"];
            $descripcion = $_POST["descripcion"];

            modificarSeccion($id_seccion,$url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion);
            echo json_encode(array(cargarDatosSeccion($id_seccion),$nombre_autor,cargarSecciones($id_biblioteca)));
        }
    }
    else echo 0;
    
?>
