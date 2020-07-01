<?php
    require_once 'funciones.php';

    $id_seccion = $_POST['id_seccion'];
    
    $datos_seccion = cargarDatosSeccion($id_seccion);
    $nombre_autor = obtenerNombreUsuario($datos_seccion['datos']['id_autor']);

    echo json_encode(array($datos_seccion,$nombre_autor));
    
?>