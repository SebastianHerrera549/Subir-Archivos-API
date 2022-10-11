<?php

include_once 'pelicula.php';

class ApiPeliculas{
    private $imagen;
    private $error;


    function getById($id){
        $pelicula = new Pelicula();
        $peliculas = array();
        $peliculas["items"] = array();

        $res = $pelicula->obtenerPelicula($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
            $item=array(
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "imagen" => $row['imagen']
            );
                array_push($peliculas["items"], $item);
        
           // echo json_encode($peliculas);
          $this-> printJson($peliculas);
        }else{
            //echo json_encode(array('mensaje' => 'No hay elementos'));
            $this-> error('No hay elementos registrados');

        }
    }
    
    function getAll(){
        $pelicula = new Pelicula();
        $peliculas = array();
        $peliculas["items"] = array();

        $res = $pelicula->obtenerPeliculas();

        if($res->rowCount()){
            while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                $item=array(
                    "id" => $row['id'],
                    "nombre" => $row['nombre'],
                    "imagen" => $row['imagen'],
                );
                array_push($peliculas["items"], $item);
            }
        
           // echo json_encode($peliculas);
          $this-> printJson($peliculas);
        }else{
            //echo json_encode(array('mensaje' => 'No hay elementos'));
            $this-> error('No hay elementos registrados');

        }
    }

    function add($item){
        $pelicula = new Pelicula();
        $res =$pelicula->nuevPelicula($item);
        $this->exito('Neva pelicula Registrada');
    }

    function exito ($mensaje){
        echo '<code>'.json_encode(array('mensaje'=> $mensaje)).'</code>';
    }

    function printJson($array){
        echo '<code>'.json_encode( $array).'</code>';
    }

    function error($mensaje){
        echo '<code>'.json_encode(array('mensaje'=> $mensaje)).'</code>';
    }

    function getImagen(){
        return $this->imagen;
    }

    function getError(){
        return $this->error;
    }

    function subirImagen($file){
        $directorio = "imagenes/";
        
        $this ->imagen = basename($file["name"]);
        $archivo = $directorio.basename($file["name"]);
        $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        // valida que es imagen
        $checarSiImagen = getimagesize($file["tmp_name"]);
        //var_dump($size);
        if($checarSiImagen != false){
            //validando tama�o del archivo
            $size = $file["size"];
            if($size > 500000){
                $this->error = "El archivo tiene que ser menor a 500kb";
                return false;
            }else{
                //validar tipo de imagen
                if($tipoArchivo == "jpg" || $tipoArchivo == "jpeg"){
                    // se valid� el archivo correctamente
                    if(move_uploaded_file($file["tmp_name"], $archivo)){
                        //echo "El archivo se subi� correctamente";
                        return true;
                    }else{
                        $this->error ="Hubo un error en la subida del archivo";
                        return false;
                    }
                }else{
                    $this->error = "Solo se admiten archivos jpg/jpeg";
                    return false;
                }
            }
        }else{
            $this->error = "El documento no es una imagen";
            return false;
        }
    }

    
}

?>