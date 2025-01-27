<?php

require_once "models/equipoModel.php";
require_once "controllers/pokemonController.php";
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

    public function buscar(string $campo, string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $pokemons = $this->model->search($campo, $metodo, $texto);

        return $pokemons;
    }

    public function listar($idUsuario)
    {
        //RECIBIMOS LOS IDS DE TODOS LOS POKEMONS QUE TIENE EL USUARIO EN FORMA DE ARRAY NORMAL
        $arrayPokemons = $this->model->readAll($idUsuario);

        $pokemonControl = new pokemonController();
        $pokemons = [];
        foreach($arrayPokemons as $idPokemon){
            array_push($pokemons, $pokemonControl->ver($idPokemon));
        }
        return $pokemons;
    }
    

}
