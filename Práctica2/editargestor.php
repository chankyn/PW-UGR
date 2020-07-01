<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);

    $bibliotecas = cargarBibliotecas();
    echo $twig->render('g_editargestor.html',[
        'name_user' => $usuario,
        'es_gestor' => $es_gestor,
        'bibliotecas' => $bibliotecas
    ]);
    
    
?>
