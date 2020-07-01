<?php
    require_once ('datosObject.class.inc');
    class Imagen extends DataObject {
        protected $datos = array(
            "id_imagen" => "",
            "tipo_imagen" => "", 
            "datos_imagen" => "",
            "nombre_imagen" => "",
            "id_autor"=>"",
            "id_biblioteca" => "", 
            "id_seccion" => "",
            "id_recurso" => ""
        );
        public static function insertarImagen($tipo_imagen,$datos_imagen,$nombre_imagen,$id_autor,$id_biblioteca,$id_seccion,$id_recurso){
            $conexion = parent::conectar();
            $sql = "INSERT INTO Imagenes
                VALUES (NULL,:tipo_imagen, :datos_imagen, :nombre_imagen, :id_autor, :id_biblioteca, :id_seccion, :id_recurso)";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":tipo_imagen", $tipo_imagen, PDO::PARAM_STR );
                $st->bindValue( ":datos_imagen", $datos_imagen, PDO::PARAM_LOB);
                $st->bindValue( ":nombre_imagen", $nombre_imagen, PDO::PARAM_STR );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->bindValue( ":id_biblioteca", $id_biblioteca, PDO::PARAM_INT );
                $st->bindValue( ":id_seccion", $id_seccion, PDO::PARAM_INT );
                $st->bindValue( ":id_recurso", $id_recurso, PDO::PARAM_INT );
                $st->execute();                    
                parent::desconectar( $conexion );
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        public static function obtenerImagenesUsuario( $id_autor ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM Imagenes WHERE id_autor = :id_autor";
            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id_autor", $id_autor, PDO::PARAM_INT );
                $st->execute();
                $imagenes = array();
                foreach ( $st->fetchAll() as $fila ) {
                    $imagenes[] = get_object_vars(new Imagen( $fila ));
                }
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                return $imagenes;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallida: " . $e->getMessage() );
            }
        }
        
    }  
?> 