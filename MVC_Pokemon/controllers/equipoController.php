<?php

require_once "models/equipoModel.php";

class equipoController{

    private $model;

    public function __construct()
    {
        $this->model = new equipoModel();
    }



    //CAMBIAR
    public function asignarPokemons($user_id, $pokemon_id){

        $this->model->asignarPokemonsEquipoModel($user_id, $pokemon_id);

    }

}
