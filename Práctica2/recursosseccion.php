<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);

    $id_seccion = $_GET["id"];

    $id_biblioteca = obtenerIdBiblioteca($id_seccion);
    if (!$id_biblioteca){
        header('Location: index.php?error=id_seccion_invalid');
    }
    $biblioteca = cargarDatosBiblioteca($id_biblioteca);
    $secciones = cargarSecciones($id_biblioteca);
    $datos_recursos = cargarRecursos($id_seccion);

    $recursos = $datos_recursos[0];
    $recursos_totales = $datos_recursos[1];

    $datos_seccion = cargarDatosSeccion($id_seccion);
    session_start();
    if(isset($_SESSION ['nombre_usuario'])){
        $user = $_SESSION['nombre_usuario'];
        echo $twig->render('recursosseccion.html',[
            'datos_seccion' => $datos_seccion,
            'recursos' => $recursos,
            'recursos_totales' => $recursos_totales,
            'datos_biblioteca' => $biblioteca,
            'secciones' => $secciones,
            'name_user' => $user
        ]);
    }else{
        echo $twig->render('recursosseccion.html',[
            'datos_seccion' => $datos_seccion,
            'recursos' => $recursos,
            'recursos_totales' => $recursos_totales,
            'datos_biblioteca' => $biblioteca,
            'secciones' => $secciones
        ]);
    }
?>
