<?php
    require_once ('datosObject.class.inc');
    class Recurso extends DataObject {
        protected $datos = array(
            "id_recurso" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "id_seccion" => "", 
            "descripcion" => ""
        );
        
        public static function insertarRecurso($url_imagen="logo.png",$nombre,$id_autor,$id_seccion,$descripcion){
            $conexion = parent::conectar();
            $sql = "INSERT INTO Recursos
                VALUES (NULL,:url_imagen, :nombre, :id_autor, :id_seccion, :descripcion)";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerIdSeccion( $id_recurso ) {
            $conexion = parent::conectar();
            $sql = "SELECT id_seccion FROM Recursos WHERE id_recurso = :id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return $fila;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerIdAutor( $id_recurso ) {
            $conexion = parent::conectar();
            $sql = "SELECT id_autor FROM Recursos WHERE id_recurso = :id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return $fila;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerRecurso( $id_recurso ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Recursos WHERE id_recurso = :id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return get_object_vars(new Recurso( $fila ));
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function obtenerRecursos( $id_seccion, $filaInicio, $numeroFilas, $orden ) {
            $conexion = parent::conectar();
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM Recursos WHERE id_seccion = :id_seccion
                ORDER BY " . $orden . " LIMIT :filaInicio, :numeroFilas";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->bindValue( ":filaInicio", $filaInicio, PDO::PARAM_INT );
                $st->bindValue( ":numeroFilas", $numeroFilas, PDO::PARAM_INT );
                $st->execute();
                $recursos = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $recursos[] = get_object_vars(new Recurso( $fila ));
                }
                $st = $conexion->query( "SELECT found_rows() AS filasTotales" );
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return array($recursos,$fila["filasTotales"]);
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerNombreRecursos( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Recursos WHERE id_seccion = :id_seccion ORDER BY id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $recursos = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $recursos[] = array($fila['id_recurso'],$fila['nombre']);
                }
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return $recursos;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerTodosRecursos( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Recursos WHERE id_seccion = :id_seccion ORDER BY id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $recursos = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $recursos[] = get_object_vars(new Recurso( $fila ));
                }
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                if ( sizeof($recursos) > 0 )
                    return $recursos;
                else return 1;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function contarRecursosSeccion( $id_seccion ) {
            $conexion = parent::conectar();
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM Recursos WHERE id_seccion = :id_seccion";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->execute();
                $st = $conexion->query( "SELECT found_rows() AS filasTotales" );
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return $fila["filasTotales"];
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function existeRecurso( $id_recurso, $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Recursos WHERE nombre = :nombre AND id_recurso != :id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
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
        public static function existe_recurso( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Recursos WHERE nombre = :nombre";
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
        public static function modificarRecurso($id_recurso,$url_imagen,$nombre,$id_autor,$id_seccion,$descripcion){
            $conexion = parent::conectar();
            $sql = "UPDATE Recursos SET url_imagen=:url_imagen, nombre=:nombre, id_autor=:id_autor, id_seccion=:id_seccion, descripcion=:descripcion WHERE id_recurso=:id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Error en la modificación del recurso. Cambie los valores.".$e);
            }
        }
        public static function eliminarRecurso( $id_recurso ) {
            $conexion = parent::conectar();
            $sql = "DELETE FROM Recursos WHERE id_recurso = :id_recurso";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->execute();
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
    }  
?> 