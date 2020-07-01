<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start(); //start the PHP_session function 
    
    if(isset($_SESSION ['nombre_usuario'])){

        $user = $_SESSION['nombre_usuario'];
        $es_gestor = es_gestor($user);

        echo $twig->render('contacto.html',[
            'name_user' => $user,
            'es_gestor' => $es_gestor
        ]);
    }else{
        echo $twig->render('contacto.html',[
        ]);
    }
    
    
?>
