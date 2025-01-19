<?php
require_once "models/pokemonModel.php";


class pokemonController{

    private $model;
    
    public function __construct(){
        $this->model= new pokemonModel();
    }

    public function devolverPokemonsLvl1(){

        return $this->model->devolverPokemonsLvl1Model();

    }



}

?>