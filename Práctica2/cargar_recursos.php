<?php
    require_once 'funciones.php';

    if (isset($_POST["data"])){
        $id_recurso = $_POST["id_recurso"];

        if ($id_recurso < 1 ) $id_recurso = 1;
        $id_autor = obtenerIdAutor($id_recurso);

        $nombre_autor = obtenerNombreUsuario($id_autor);
        $datos_recursos = cargarDatosRecurso($id_recurso);
        $nombre_seccion = obtenerNombreSeccion($datos_recursos['datos']['id_seccion']);


        echo json_encode(array($datos_recursos,$nombre_autor,$nombre_seccion));
    }
    elseif(isset($_POST["seccion"])){
        $id_seccion = $_POST["id_seccion"];
        $datos_recursos = obtenerTodosRecursos($id_seccion);
        $nombre_autor = obtenerNombreUsuario($datos_recursos[0]['datos']['id_autor']);
        echo json_encode(array($datos_recursos,$nombre_autor));
    }
    elseif(isset($_POST["datos_recurso"])){
        $id_recurso = $_POST["id_recurso"];
        $datos_recursos = cargarDatosRecurso($id_recurso);
        $nombre_autor = obtenerNombreUsuario($datos_recursos['datos']['id_autor']);
        echo json_encode(array($datos_recursos,$nombre_autor));
    }
    else
    {
        $id_seccion = $_POST["id_seccion"];
        $fila_inicio = $_POST["fila_inicio"];
        $numero_filas = $_POST["numero_filas"];
        $datos_recursos = cargarRecursos($id_seccion,$fila_inicio,$numero_filas);
    
        echo json_encode($datos_recursos[0]);
    }
    
?>