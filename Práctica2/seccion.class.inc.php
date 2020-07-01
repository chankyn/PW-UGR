<?php
    require_once ('datosObject.class.inc');
    class Seccion extends DataObject {
        protected $datos = array(
            "id_seccion" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "descripcion" => ""
        );
        
        public static function insertarSeccion($url_imagen="logo.png",$nombre,$id_autor,$id_biblioteca,$descripcion){
            $conexion = parent::conectar();
            $sql = "INSERT INTO Secciones
                VALUES (NULL,:url_imagen, :nombre, :id_autor, :id_biblioteca, :descripcion)";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function modificarSeccion($id_seccion,$url_imagen,$nombre,$id_autor,$id_biblioteca,$descripcion){
            $conexion = parent::conectar();
            $sql = "UPDATE Secciones SET url_imagen=:url_imagen, nombre=:nombre, id_autor=:id_autor, id_biblioteca=:id_biblioteca, descripcion=:descripcion WHERE id_seccion=:id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Error en la modificación de la sección. Cambie los valores.");
            }
        }
        public static function existeSeccion( $id_seccion, $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Secciones WHERE nombre = :nombre AND id_seccion != :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
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
        public static function existe_seccion( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Secciones WHERE nombre = :nombre";
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
        public static function obtenerSeccion( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Secciones WHERE id_seccion = :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return get_object_vars(new Seccion( $fila ));
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerIdBiblioteca( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT id_biblioteca FROM Secciones WHERE id_seccion = :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return $fila['id_biblioteca'];
                else return false;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerNombreSeccion( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT nombre FROM Secciones WHERE id_seccion = :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return $fila['nombre'];
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerSecciones($id_biblioteca) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Secciones WHERE id_biblioteca = :id_biblioteca";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->execute();
                $secciones = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $secciones[] = get_object_vars(new Seccion( $fila ));
                }
                $st = $conexion->query( "SELECT found_rows() AS filasTotales" );
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return $secciones;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function eliminarSeccion( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "DELETE FROM Secciones WHERE id_seccion = :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
    }  
?> 