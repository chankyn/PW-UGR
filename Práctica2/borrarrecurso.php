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
    $nombre_recursos = cargarNombreRecursos($secciones[0]['datos']['id_seccion']);
    session_start();
    
    if(isset($_SESSION ['nombre_usuario'])){

        $user = $_SESSION['nombre_usuario'];
        echo $twig->render('borrarrecurso.html',[
            'name_user' => $user,
            'secciones' => $secciones,
            'autor' => $nombre_autor,
            'datos_biblioteca' => $datos_biblioteca,
            'recursos' => $nombre_recursos
        ]);
    }else{
        echo $twig->render('borrarrecurso.html',[
            'secciones' => $secciones,
            'autor' => $nombre_autor,
            'datos_biblioteca' => $datos_biblioteca,
            'recursos' => $nombre_recursos
        ]);
    }
    
?>
