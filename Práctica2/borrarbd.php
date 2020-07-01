<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);

    $id_biblioteca = $_GET["id"];
    if (isset($_GET['borrar'])){
        if (!cargarDatosBiblioteca($id_biblioteca))
            echo 0;
        else echo eliminarBiblioteca($id_biblioteca);
    }else{
        $datos_biblioteca = cargarDatosBiblioteca($id_biblioteca);
        $secciones = cargarSecciones($id_biblioteca);

        echo $twig->render('borrarbd.html',[
            'datos_biblioteca' => $datos_biblioteca,
            'secciones' => $secciones
        ]);
    }
    

?>
