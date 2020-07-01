<?php
    require_once ('datosObject.class.inc');
    class Usuario extends DataObject {
        protected $datos = array(
            "id_usuario" => "",
            "nombre" => "", 
            "password" => "",
            "apellidos"=>"",
            "direccion" => "", 
            "es_gestor" => ""
        );
        public static function obtenerNombreUsuario( $id_usuario ) {
            $conexion = parent::conectar();
            $sql = "SELECT nombre FROM Usuarios WHERE id_usuario = :id_usuario";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_usuario", $id_usuario, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return $fila['nombre'];
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function existe_usuario( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Usuarios WHERE nombre = :nombre";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return true;
                else return false;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function buscarUsuario( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Usuarios WHERE nombre LIKE :nombre";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", "%".$nombre."%", PDO::PARAM_STR );
                $st->execute();
                $resultados = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $resultados[] =  $fila['nombre'] ;
                }
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                
                return $resultados;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
       
        public static function obtenerUsuario( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Usuarios WHERE nombre = :nombre";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->execute();
               
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return get_object_vars(new Usuario( $fila ));
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function comprobarUsuario( $nombre, $pass ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Usuarios WHERE nombre = :nombre AND password = :pass";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":pass", $pass, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return true;
                else return false;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function es_gestor( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Usuarios WHERE nombre = :nombre AND es_gestor = 1";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return true;
                else return false;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function insertarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor){
            $conexion = parent::conectar();
            $sql = "INSERT INTO Usuarios
                VALUES (NULL,:nombre, :pass, :apellidos, :direccion, :es_gestor)";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":pass", $pass, PDO::PARAM_STR );
                $st->bindValue( ":apellidos", $apellidos, PDO::PARAM_STR );
                $st->bindValue( ":direccion", $direccion, PDO::PARAM_STR );
                $st->bindValue( ":es_gestor", $es_gestor, PDO::PARAM_INT );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function modificarUsuario($nombre,$pass,$apellidos,$direccion,$es_gestor){
            $conexion = parent::conectar();
            if (empty($pass))
                $sql = "UPDATE Usuarios SET apellidos=:apellidos, direccion=:direccion, es_gestor=:es_gestor WHERE nombre=:nombre";
            else
                $sql = "UPDATE Usuarios SET password=:pass, apellidos=:apellidos, direccion=:direccion, es_gestor=:es_gestor WHERE nombre=:nombre";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                if (!empty($pass)) $st->bindValue( ":pass", $pass, PDO::PARAM_STR );
                $st->bindValue( ":apellidos", $apellidos, PDO::PARAM_STR );
                $st->bindValue( ":direccion", $direccion, PDO::PARAM_STR );
                $st->bindValue( ":es_gestor", $es_gestor, PDO::PARAM_INT );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function eliminarUsuario( $nombre ) {
            $conexion = parent::conectar();
            $sql = "DELETE FROM Usuarios WHERE nombre = :nombre";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->execute();
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
    }  
?> 