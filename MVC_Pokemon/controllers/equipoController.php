<?php

require_once "models/equipoModel.php";

class equipoController{

    private $model;

    public function __construct()
    {
        $this->model = new equipoModel();
    }



    //CAMBIAR
    public function asignarPokemons($user_id, $pokemon_id, $numeroPokemon){

        $this->model->asignarPokemonsEquipoModel($user_id, $pokemon_id, $numeroPokemon);

    }

    public function buscar(string $campo, string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $pokemons = $this->model->search($campo, $metodo, $texto);

        return $pokemons;
    }


    

}
