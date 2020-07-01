<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);

    $id_recurso = $_GET["id"];
    $id_seccion = obtenerIdSeccion($id_recurso);
    $id_biblioteca = obtenerIdBiblioteca($id_seccion);
    $id_autor = obtenerIdAutor($id_recurso);

    $secciones = cargarSecciones($id_biblioteca);

    $datos_biblioteca = cargarDatosBiblioteca($id_biblioteca);
    $datos_recurso = cargarDatosRecurso($id_recurso);

    $nombre_autor = obtenerNombreUsuario($id_autor);
    $nombre_seccion = obtenerNombreSeccion($id_seccion);

    session_start();
    if(isset($_SESSION ['nombre_usuario'])){
        $user = $_SESSION['nombre_usuario'];
        echo $twig->render('recurso.html',[
            'datos_recurso' => $datos_recurso,
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'nombre_autor' => $nombre_autor,
            'nombre_seccion' => $nombre_seccion,
            'name_user' => $user
        ]);
    }else{
        echo $twig->render('recurso.html',[
            'datos_recurso' => $datos_recurso,
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones,
            'nombre_autor' => $nombre_autor,
            'nombre_seccion' => $nombre_seccion
        ]);
    }

?>
