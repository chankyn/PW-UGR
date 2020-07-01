<?php
    require_once 'funciones.php';

    if (isset($_POST["nombre"]))
        $nombre = $_POST["nombre"];
    else $nombre = "";

    if (isset($_POST["datos"])){
        $existe_usuario = existe_usuario($nombre);
        if ($existe_usuario){
            $datos_usuario = obtenerUsuario($nombre);
            echo json_encode($datos_usuario);
        }
    }else {
        $busqueda = buscarUsuarios($nombre);
        echo json_encode($busqueda);
    }
    
    
?>