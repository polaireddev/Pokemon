<?php
require_once('config/db.php');

class PokemonModel{

    private $conexion;

    public function __construct(){
        $this->conexion = db::conexion();
    }

    public function devolverPokemonsLvl1Model(){
        
        try {

            $sentencia = $this->conexion->prepare("SELECT id FROM pokemon WHERE nivel = 1;");
            $sentencia->execute();

            $pokemons = $sentencia->fetchAll(PDO::FETCH_COLUMN);
            return $pokemons;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }

    }

    

}

?>