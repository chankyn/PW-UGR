<?php 
    require_once 'vendor/autoload.php';
    require_once 'funciones.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader,[ ]);
    
    session_start();
    $usuario = $_SESSION['nombre_usuario'];
    $es_gestor = es_gestor($usuario);

    if (isset($_POST["borrar"])){
        if ($es_gestor){
            $nombre = $_POST["nombre"];
            if (!existe_usuario($nombre)){
                echo 1;
            }else{
                eliminarUsuario( $nombre );
                echo "Usuario eliminado con éxito.";
            }
            
        }else echo 0;
    }else{
        $bibliotecas = cargarBibliotecas();
        echo $twig->render('g_borrargestor.html',[
            'name_user' => $usuario,
            'es_gestor' => $es_gestor,
            'bibliotecas' => $bibliotecas
        ]);
    }
    
    
?>
