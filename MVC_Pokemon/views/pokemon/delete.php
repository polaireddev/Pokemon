<?php
require_once "controllers/pokemonController.php";

if (!isset ($_REQUEST["id"])){
    header('location:index.php' );
    exit();
 }
 //recoger datos
 $id=$_REQUEST["id"];
 
 $controlador= new pokemonController();
 $borrado=$controlador->borrar ($id);


?>