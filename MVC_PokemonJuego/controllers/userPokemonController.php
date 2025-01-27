<?php
require_once "controllers/pokemonController.php";
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

    
    public function mostrarPokemonsUsuario($id){
        $this->model->mostrarPokemonsUsuarioModel($id);
    }

    public function listar($idUsuario): array
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
?>