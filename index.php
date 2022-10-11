<?php
    include_once 'apipeliculas.php';
    $api = new ApiPeliculas();
    echo"<pre>";
    if(isset($_GET['id'])){    
        $id =$_GET['id'];

        if(is_numeric($id)){
            $api->getById($id);
        }else{
            $api-> error('El id NO es numerico');
        }


    }else{
        $api->getAll();
    }
    
?>