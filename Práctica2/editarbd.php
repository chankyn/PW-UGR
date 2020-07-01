<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);

    $id_biblioteca = $_GET["id"];
    $datos_biblioteca = cargarDatosBiblioteca($id_biblioteca);
    if (!$datos_biblioteca){
        header('Location: index.php?error=id_biblio_invalid');
    }
    $secciones = cargarSecciones($id_biblioteca);
    $nombre_autor = obtenerNombreUsuario($datos_biblioteca['datos']['id_autor']);

    session_start(); //start the PHP_session function 
    
    if(isset($_SESSION ['nombre_usuario'])){
        $user = $_SESSION['nombre_usuario'];
        
        echo $twig->render('editarbd.html',[
            'name_user' => $user,
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'nombre_autor' => $nombre_autor
        ]);
    }else{
        echo $twig->render('editarbd.html',[
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'nombre_autor' => $nombre_autor
        ]);
    }


?>
