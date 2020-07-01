<?php
    require_once 'funciones.php';

    $elem_actuales = $_POST['elem_actuales'];
    $elem_totales = obtenerNumBibliotecas();
    
    if ($elem_actuales < $elem_totales){
        $bibliotecas = cargarBibliotecas($elem_actuales,$elem_actuales+3);
        session_start(); //start the PHP_session function 
        
        if(isset($_SESSION ['nombre_usuario'])){
            $user = $_SESSION['nombre_usuario'];
            $es_gestor = es_gestor($user);
            echo json_encode(array($bibliotecas,$es_gestor));
        }else{
            echo json_encode(array($bibliotecas,false));
        }
    }
    else echo 0;
   
    
?>