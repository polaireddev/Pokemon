<?php
require_once "controllers/pokemonController.php";
require_once "models/userPokemonModel.php";
require_once "controllers/equipoController.php";


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

    public function insertarPokemonUsuario($idUsuario){
        $controladorPokemon = new pokemonController();
        $arrayPokemonsLvl1 = $controladorPokemon->devolverPokemonsLvl1();

        $pokemonsUsuario = $this->model->readAll($idUsuario);
        $arrayPokemonsLvl1Usuario = [];

        //Recogemos todos los pokemons de nivel 1 del usuario
        foreach($pokemonsUsuario as $pokemonUsuario){
            foreach($arrayPokemonsLvl1 as $pokemonlvl1){
                if ($pokemonUsuario == $pokemonlvl1){
                    array_push($arrayPokemonsLvl1Usuario, $pokemonUsuario);
                }
            }
        }

        //Guardamos los pokemons de lvl 1 que el usuario no tiene
        $pokemonsLvl1Libres = [];
        foreach ($arrayPokemonsLvl1 as $pokemonlvl1){
            $contador = 0;
            foreach ($arrayPokemonsLvl1Usuario as $pokemonUsuario){
                if ($pokemonlvl1 == $pokemonUsuario){
                    $contador++;
                }
            }
            if($contador == 0){
                array_push($pokemonsLvl1Libres, $pokemonlvl1);
            }
        }

        $pokemonAsignado = $pokemonsLvl1Libres[rand(1, count($pokemonsLvl1Libres)) - 1];

        $this->model->asignarPokemonsModel($idUsuario, $pokemonAsignado);
        return $pokemonAsignado;
    }


    public function verPokemon($idPokemon){
        $pokemonControl = new pokemonController();

        return $pokemonControl->ver($idPokemon);

    }

    public function modificarEvolucion($idPokemon, $idPokemonEvolucionado, $idUsuario){
        $this->model->modificarEvolucionModel($idPokemon, $idPokemonEvolucionado, $idUsuario);

        $this->model->restarEvoluciones($idUsuario);
        //controlar que el usuario tengo evolucinoes disponibles 

        $equipoControl = new equipoController();
        $pokemons = $equipoControl->listar($idUsuario);
        foreach($pokemons as $pokemon){
            if($pokemon->id == $idPokemon){
                $equipoControl->eliminarPokemonEquipo($idUsuario, $idPokemon);
                $equipoControl->asignarPokemons($idUsuario, $idPokemonEvolucionado);
            }
        }
        
    }




    public function listarPokemonsLvlBajo($idUsuario): array
    {
        //RECIBIMOS LOS IDS DE TODOS LOS POKEMONS QUE TIENE EL USUARIO EN FORMA DE ARRAY NORMAL
        $arrayPokemons = $this->model->readAll($idUsuario);

        $pokemonControl = new pokemonController();
        $pokemons = [];
        foreach($arrayPokemons as $idPokemon){
            $comprobarPokemon = $pokemonControl->ver($idPokemon);
            if($comprobarPokemon->nivel < 3 && $comprobarPokemon->id_evolucion != null){
                array_push($pokemons, $pokemonControl->ver($idPokemon));
            }
        }
        return $pokemons;
    }


}
?>
