<?php 
    require_once 'usuario.class.inc.php';
    require_once 'biblioteca.class.inc.php';
    require_once 'seccion.class.inc.php';
    require_once 'recurso.class.inc.php';
    require_once 'imagen.class.inc.php';
    
    function comprobar_usuario($user,$pass){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        
        return $usuario->comprobarUsuario($user,$pass);
    }
    function es_gestor($nombre_usuario){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->es_gestor($nombre_usuario);
    }
    function existe_usuario($nombre_usuario){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->existe_usuario($nombre_usuario);
    }
    function obtenerNombreUsuario($id_usuario){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->obtenerNombreUsuario($id_usuario);
    }
    function insertarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->insertarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor);
    }

    function modificarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->modificarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor);
    }

    function buscarUsuarios($nombre){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->buscarUsuario($nombre);
    }

    function obtenerUsuario($nombre){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->obtenerUsuario($nombre);
    }

    function eliminarUsuario($nombre){
        $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
    
        $usuario = new Usuario($datos);
        return $usuario->eliminarUsuario($nombre);
    }
    
    function cargarBibliotecas($filaIni=0, $numFilas=4, $orden="id_biblioteca" ){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->obtenerBibliotecas($filaIni,$numFilas,$orden);
    }

    function insertarBiblioteca($url_imagen,$nombre,$id_autor,$fuente,$descripcion){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->insertarBiblioteca($url_imagen,$nombre,$id_autor,$fuente,$descripcion);
    }
    function existeBiblioteca( $id_biblioteca, $nombre ){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->existeBiblioteca( $id_biblioteca, $nombre );
    }

    function existe_biblioteca( $nombre ){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->existe_biblioteca( $nombre );
    }

    function obtenerNumBibliotecas(){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->obtenerNumBibliotecas();
    }
    
    function cargarDatosBiblioteca($id_biblioteca){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->obtenerBiblioteca($id_biblioteca);
    }
    function modificarBiblioteca($id_biblioteca,$url_imagen,$nombre,$id_autor,$fuente,$descripcion){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->modificarBiblioteca($id_biblioteca,$url_imagen,$nombre,$id_autor,$fuente,$descripcion);
    }
    function eliminarBiblioteca($id_biblioteca){
        $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        $biblioteca = new Biblioteca($datos);
        return $biblioteca->eliminarBiblioteca($id_biblioteca);
    }

    function insertarSeccion($url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->insertarSeccion($url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion);
    }

    function cargarSecciones($id_biblioteca){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->obtenerSecciones($id_biblioteca);
    }

    function cargarDatosSeccion($id_seccion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->obtenerSeccion($id_seccion);
    }
    
    function obtenerIdBiblioteca($id_seccion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->obtenerIdBiblioteca($id_seccion);
    }

    function obtenerNombreSeccion($id_seccion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->obtenerNombreSeccion($id_seccion);
    }
    function existeSeccion( $id_seccion, $nombre ){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->existeSeccion( $id_seccion, $nombre );
    }
    function existe_seccion( $nombre ){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->existe_seccion( $nombre );
    }
    function modificarSeccion($id_seccion,$url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->modificarSeccion($id_seccion,$url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion);
    }

    function eliminarSeccion($id_seccion){
        $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        $seccion = new Seccion($datos);
        return $seccion->eliminarSeccion($id_seccion);
    }

    function insertarRecurso($url_imagen,$nombre,$id_autor,$id_seccion,$descripcion){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->insertarRecurso($url_imagen,$nombre,$id_autor,$id_seccion,$descripcion);
    }
    function cargarRecursos($id_seccion, $filaInicio=0, $numeroFilas=9, $orden="id_recurso" ){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerRecursos($id_seccion, $filaInicio, $numeroFilas, $orden);
    }
    function cargarDatosRecurso($id_recurso){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerRecurso($id_recurso);
    }
    function cargarNombreRecursos($id_seccion){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerNombreRecursos($id_seccion);
    }
    function obtenerTodosRecursos( $id_seccion){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerTodosRecursos( $id_seccion);
    }
    function obtenerIdSeccion( $id_recurso ){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerIdSeccion($id_recurso);
    }
    function obtenerIdAutor($id_recurso){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->obtenerIdAutor($id_recurso);
    }
    function contarRecursosSeccion( $id_seccion ) {
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->contarRecursosSeccion( $id_seccion ) ;
    }
    
    function modificarRecurso($id_recurso,$url_imagen,$nombre,$id_autor,$id_seccion,$descripcion) {
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->modificarRecurso($id_recurso,$url_imagen,$nombre,$id_autor,$id_seccion,$descripcion) ;
    }
    
    function existeRecurso( $id_recurso, $nombre ) {
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->existeRecurso( $id_recurso, $nombre ) ;
    }
    
    function existe_recurso( $nombre ) {
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->existe_recurso( $nombre ) ;
    }

    function eliminarRecurso($id_recurso ){
        $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        $recurso = new Recurso($datos);
        return $recurso->eliminarRecurso( $id_recurso );
    }
    
    function insertarImagen($tipo_imagen,$datos_imagen,$nombre_imagen,$id_autor,$id_biblioteca,$id_seccion,$id_recurso){
        $datos = array(
            "id_imagen" => "",
            "tipo_imagen" => "", 
            "imagen" => "",
            "nombre_imagen" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "id_seccion" => "",
            "id_recurso" => ""
        );
        $imagen = new imagen($datos);
        return $imagen->insertarImagen($tipo_imagen,$datos_imagen,$nombre_imagen,$id_autor,$id_biblioteca,$id_seccion,$id_recurso);
    }
    
    function obtenerImagenesUsuario($id_autor){
        $datos = array(
            "id_imagen" => "",
            "tipo_imagen" => "", 
            "imagen" => "",
            "nombre_imagen" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "id_seccion" => "",
            "id_recurso" => ""
        );
        $imagen = new imagen($datos);
        return $imagen->obtenerImagenesUsuario($id_autor);
    }
?>
