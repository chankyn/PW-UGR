<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
    $es_gestor = es_gestor($usuario);

    if (isset($_POST["insertar"])){

        $nombre = $_POST["nombre"];
        $pass = $_POST["pass"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $tipo = $_POST["tipo"];

        if(existe_usuario($nombre))
            echo 0;
        else
        {
            insertarUsuario($nombre,$pass,$apellidos,$direccion,$tipo);
            echo 1;
        }
    }else{
        $bibliotecas = cargarBibliotecas();
        echo $twig->render('g_altagestor.html',[
            'name_user' => $usuario,
            'es_gestor' => $es_gestor,
            'bibliotecas' => $bibliotecas
        ]);
    }
        
        
        

    
    
?>
