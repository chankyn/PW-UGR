<?php

require_once 'funciones.php';

session_start();
isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
if (existe_usuario($usuario)){
    $id_autor = obtenerUsuario($usuario)['datos']['id_usuario'];
    $imagenes = obtenerImagenesUsuario($id_autor);

    echo json_encode($imagenes);
}else echo 0;
