<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);

    $user = $_POST["usuario"];
    $pass = $_POST["password"];
    $location = $_POST["location"];
    
    $es_valido = comprobar_usuario($user,$pass);
    
    if ($es_valido){
        $es_gestor = es_gestor($user);
        $bibliotecas = cargarBibliotecas();

        session_start(); //start the PHP_session function 
        $_SESSION['nombre_usuario'] = $user;
       
        header('Location: '.$location);
    }
        
    else header('Location: '.$location.'?error=login');
   
    

?>
