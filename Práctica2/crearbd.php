<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);

    if (isset($_POST["insertar"])){

        $nombre = $_POST["nombre"];
        $url_imagen = $_POST["url_imagen"];
        $autor = $_POST["autor"];
        $fuente = $_POST["fuente"];
        $descripcion = $_POST["descripcion"];

        if(!existe_usuario($autor))
            echo 0;
        elseif (existe_biblioteca($nombre))
            echo 1;
        else{
            $id_autor = obtenerUsuario($autor)['datos']['id_usuario'];
            insertarBiblioteca($url_imagen,$nombre,$id_autor,$fuente,$descripcion);
            echo 2;
        }
    }else{
        echo $twig->render('crearbd.html',[
            'name_user' => $usuario,
            'es_gestor' => $es_gestor
        ]);
    }
        
        
        

    
    
?>
