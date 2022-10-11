<?php

include_once 'db.php';
// alcance especifico a la base de datos 
class Pelicula extends DB{
    
    function obtenerPeliculas(){
        $query = $this->connect()->query('SELECT * FROM pelicula');
        return $query;
    }

    function obtenerPelicula($id){
        $query = $this->connect()->prepare('SELECT * FROM pelicula WHERE id= :id');
        $query ->execute(['id'=>$id]);
        return $query;
    }

    function nuevPelicula($pelicula){
        $query = $this->connect()->prepare('INSERT INTO pelicula (nombre, imagen) VALUES (:nombre, :imagen)');
        $query ->execute(['nombre'=>$pelicula['nombre'], 'imagen'=>$pelicula['imagen']]);
        return $query;
    }

}

?>