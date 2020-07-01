<?php
    require_once 'funciones.php';

    $id_biblioteca = $_POST["id_biblioteca"];
    session_start();
    isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";

    if (!existe_usuario($usuario))
        echo 0;
    else{
        $id_usuario = obtenerUsuario($usuario)['datos']['id_usuario'];
        $recursos = array();
        $datos_secciones = cargarSecciones($id_biblioteca);
        foreach ($datos_secciones as $datos_seccion) {
            $datos_recursos = obtenerTodosRecursos($datos_seccion['datos']['id_seccion']);
            if ($datos_recursos != 1)
                foreach ($datos_recursos as $datos_recurso)
                    if ( $id_usuario == $datos_recurso['datos']['id_autor'])
                        $recursos[] = $datos_recurso['datos']['nombre'];
        }
    }
    echo json_encode($recursos);
?>