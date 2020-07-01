<?php

require_once 'funciones.php';

/* Comprobamos que el usuario tiene una sesión activa. */
session_start();
isset($_SESSION['nombre_usuario']) ? $usuario = $_SESSION['nombre_usuario'] : $usuario = "";
$existe = existe_usuario($usuario);

/* Obtenemos el nombre del archivo */
isset($_FILES['file']['name']) ? $nombre_imagen = $_FILES['file']['name'] : $nombre_imagen = false;

if(!$existe){
   echo 0;
}elseif(!$nombre_imagen){
   echo 1;
}else{
   $tipo_imagen = pathinfo($nombre_imagen,PATHINFO_EXTENSION);
   $datos_imagen = file_get_contents($_FILES['file']['tmp_name']);

   $uploadOk = 1;
   $id_usuario = obtenerUsuario($usuario)['datos']['id_usuario'];

   /* Extensiones que se permiten */
   $valid_extensions = array("jpg","jpeg","png");
   /* Comprueba que la extensión es válida. */
   if( !in_array(strtolower($tipo_imagen),$valid_extensions) ) {
      $uploadOk = 0;
   }

   if($uploadOk == 0){
      echo 2;
   }else{
      /* Comprobamos que la imagen corresponde a alguna biblioteca, seccion o recurso */
      isset($_POST['id_biblioteca']) ? $id_biblioteca = $_POST['id_biblioteca'] : $id_biblioteca = NULL;
      isset($_POST['id_seccion']) ? $id_seccion = $_POST['id_seccion'] : $id_seccion = NULL;
      isset($_POST['id_recurso']) ? $id_recurso = $_POST['id_recurso'] : $id_recurso = NULL;

      /* Subimos la imagen nueva */
      $datos_imagen = "data:image/".$tipo_imagen.";base64,".base64_encode($datos_imagen);
      insertarImagen($tipo_imagen,$datos_imagen,$nombre_imagen,$id_usuario,$id_biblioteca,$id_seccion,$id_recurso);
      echo $datos_imagen;
   }
}

?>