<?php

require_once "models/userPokemonModel.php";

class userPokemonController
{

    private $model;

    public function __construct()
    {
        $this->model = new userPokemonModel();
    }


    public function asignarPokemons($user_id, $pokemon_id){

        $this->model->asignarPokemonsModel($user_id, $pokemon_id);

    }



}
?>