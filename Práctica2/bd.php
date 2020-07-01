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
    $num_recursos = 0;
    foreach ($secciones as $seccion)
        $num_recursos += contarRecursosSeccion($seccion['datos']['id_seccion']);
    session_start(); //start the PHP_session function 
    $nombre_autor = obtenerNombreUsuario($datos_biblioteca['datos']['id_autor']);
    if(isset($_SESSION ['nombre_usuario'])){

        $user = $_SESSION['nombre_usuario'];
        echo $twig->render('bd.html',[
            'name_user' => $user,
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'autor' => $nombre_autor,
            'num_recursos' => $num_recursos
        ]);
    }else{
        echo $twig->render('bd.html',[
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'autor' => $nombre_autor,
            'num_recursos' => $num_recursos
        ]);
    }
    

?>
