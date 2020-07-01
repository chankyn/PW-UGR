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
        $id_seccion = $_POST["id_seccion"];
        $url_imagen = $_POST["url_imagen"];
        $autor = $_POST["autor"];
        $descripcion = $_POST["descripcion"];
        if(!existe_usuario($autor)){
            echo 0;
        }
        elseif (existe_recurso($nombre))
            echo 1;
        else{
            $id_autor = obtenerUsuario($autor)['datos']['id_usuario'];
            insertarRecurso($url_imagen,$nombre,$id_autor,$id_seccion,$descripcion);
            echo 2;
        }
    }else{
        $id_biblioteca = $_GET["id"];
        $datos_biblioteca = cargarDatosBiblioteca($id_biblioteca);
        if (!$datos_biblioteca){
            header('Location: index.php?error=id_biblio_invalid');
        }
        $secciones = cargarSecciones($id_biblioteca);
        $nombre_autor = obtenerNombreUsuario($datos_biblioteca['datos']['id_autor']);
        echo $twig->render('altarecurso.html',[
            'secciones' => $secciones,
            'name_user' => $usuario,
            'es_gestor' => $es_gestor,
            'datos_biblioteca' => $datos_biblioteca
        ]);
    }
    
?>
