<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";

    if (!existe_usuario($usuario))
        echo 0;
    else{
        $datos_usuario = obtenerUsuario($usuario);
        echo json_encode($datos_usuario);
    }
    
?>
