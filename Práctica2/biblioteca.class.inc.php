<?php
    require_once ('datosObject.class.inc');
    class Biblioteca extends DataObject {
        protected $datos = array(
            "id_biblioteca" => "",
            "url_imagen" => "", 
            "nombre" => "",
            "id_autor"=>"",
            "fuente" => "", 
            "descripcion" => ""
        );
        
        public static function insertarBiblioteca($url_imagen="logo.png",$nombre,$id_autor,$fuente,$descripcion){
            $conexion = parent::conectar();
            $sql = "INSERT INTO Bibliotecas
                VALUES (NULL,:url_imagen, :nombre, :id_autor, :fuente, :descripcion)";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":fuente", $fuente, PDO::PARAM_STR );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerBiblioteca( $id_biblioteca ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Bibliotecas WHERE id_biblioteca = :id_biblioteca";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch(); 
                parent::desconectar( $conexion );
                if ( $fila ) return get_object_vars(new Biblioteca( $fila ));
                else return false;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        public static function existeBiblioteca( $id_biblioteca, $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Bibliotecas WHERE nombre = :nombre AND id_biblioteca != :id_biblioteca";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
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
        public static function existe_biblioteca( $nombre ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Bibliotecas WHERE nombre = :nombre";
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
        public static function obtenerBibliotecas( $filaInicio, $numeroFilas, $orden ) {
            $conexion = parent::conectar();
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM Bibliotecas
                ORDER BY " . $orden . " LIMIT :filaInicio, :numeroFilas";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":filaInicio", $filaInicio, PDO::PARAM_INT );
                $st->bindValue( ":numeroFilas", $numeroFilas, PDO::PARAM_INT );
                $st->execute();
                $bibliotecas = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $bibliotecas[] = get_object_vars(new Biblioteca( $fila ));
                }
                $st = $conexion->query( "SELECT found_rows() AS filasTotales" );
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return $bibliotecas;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerNumBibliotecas( ) {
            $conexion = parent::conectar();
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM Bibliotecas";
            try {
                $st = $conexion->prepare( $sql );
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
        public static function modificarBiblioteca($id_biblioteca,$url_imagen,$nombre,$id_autor,$fuente,$descripcion){
            $conexion = parent::conectar();
            $sql = "UPDATE Bibliotecas SET url_imagen=:url_imagen, nombre=:nombre, id_autor=:id_autor, fuente=:fuente, descripcion=:descripcion WHERE id_biblioteca=:id_biblioteca";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->bindValue( ":url_imagen", $url_imagen, PDO::PARAM_STR );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":fuente", $fuente, PDO::PARAM_STR );
                $st->bindValue( ":descripcion", $descripcion, PDO::PARAM_STR );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Error en la modificación de la biblioteca. Cambie los valores.");
            }
        }
        public static function eliminarBiblioteca( $id_biblioteca ) {
            $conexion = parent::conectar();
            $sql = "DELETE FROM Bibliotecas WHERE id_biblioteca = :id_biblioteca";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->execute();
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
    }  
?> 