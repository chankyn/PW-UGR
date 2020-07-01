<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    $bibliotecas = cargarBibliotecas();
    session_start(); //start the PHP_session function 
    
    if(isset($_SESSION ['nombre_usuario'])){

        $user = $_SESSION['nombre_usuario'];
        $es_gestor = es_gestor($user);

        echo $twig->render('g_gestorbd.html',[
            'name_user' => $user,
            'es_gestor' => $es_gestor,
            'bibliotecas' => $bibliotecas
        ]);
    }else{
        echo $twig->render('g_portada.html',[
            'bibliotecas' => $bibliotecas
        ]);
    }
    
    
?>
