<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    isset($_POST['permisos']) ? $perfil_usuario = true : $perfil_usuario = false;
    $es_gestor = es_gestor($usuario);

    if ($es_gestor || $perfil_usuario){
        $nombre = $_POST["nombre"];
        if (!existe_usuario($nombre)){
            echo 1;
        }else{
            $pass = $_POST["pass"];
            $apellidos = $_POST["apellidos"];
            $direccion = $_POST["direccion"];
            if(isset($_SESSION['tipo'])) 
                $es_gestor = $_POST["tipo"];
            modificarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor);
            echo "Datos modificados con éxito.";
        }
        
    }
    else echo 0;
    
?>
