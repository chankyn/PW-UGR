<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    //Comprobamos que el usuario es gestor o al menos, es el creador de la biblioteca para poder modificarla.
    $id_biblioteca = $_POST['id'];

    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);
    
    $id_autor_biblioteca = cargarDatosBiblioteca($id_biblioteca)['datos']['id_autor'];
    $nombre_autor_biblioteca = obtenerNombreUsuario($id_autor_biblioteca);

    if ($es_gestor || $nombre_autor_biblioteca == $usuario ){
        $nombre = $_POST["nombre"];
        $nombre_autor = $_POST["autor"];
        if (existeBiblioteca($id_biblioteca,$nombre)){
            echo 1;
        }elseif (!existe_usuario($nombre_autor)){
            echo 2;
        }else{
            $id_autor = obtenerUsuario($nombre_autor)["datos"]["id_usuario"];
            $fuente = $_POST["fuente"];
            $descripcion = $_POST["descripcion"];
            $url_imagen = $_POST["url_imagen"];

            modificarBiblioteca($id_biblioteca,$url_imagen,$nombre,$id_autor,$fuente,$descripcion);
            echo json_encode(array(cargarDatosBiblioteca($id_biblioteca),$nombre_autor));
        }
    }
    else echo 0;
    
?>
