<?php

require_once "models/equipoModel.php";
require_once "controllers/pokemonController.php";
require_once "controllers/userPokemonController.php";
class equipoController
{

    private $model;

    public function __construct()
    {
        $this->model = new equipoModel();
    }



    //CAMBIAR
    public function asignarPokemons($user_id, $pokemon_id)
    {

        $this->model->asignarPokemonsEquipoModel($user_id, $pokemon_id);
    }

    public function buscar(string $campo, string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $pokemons = $this->model->search($campo, $metodo, $texto);

        return $pokemons;
    }

    public function listar($idUsuario) //ME DEVUELVE LOS POKEMONS DEL EQUIPO  SOLO?
    {
        //RECIBIMOS LOS IDS DE TODOS LOS POKEMONS QUE TIENE EL USUARIO EN FORMA DE ARRAY NORMAL??? 
        $arrayPokemons = $this->model->readAll($idUsuario);

        $pokemonControl = new pokemonController();
        $pokemons = [];
        foreach ($arrayPokemons as $idPokemon) {
            array_push($pokemons, $pokemonControl->ver($idPokemon));
        }
        return $pokemons;
    }

    public function listarTodos($idUsuario)
    {
        //RECIBIMOS LOS IDS DE TODOS LOS POKEMONS QUE TIENE EL USUARIO EN FORMA DE ARRAY NORMAL??
        $controlador = new userPokemonController();
        $pokemons = $controlador->listar($idUsuario);

        return $pokemons;
    }




    public function crear($idUsuario, $idPokemon1, $idPokemon2, $idPokemon3, $order1, $order2, $order3)
    {
        $error = false;
        $errores = [];

        // vaciamos errores
        $_SESSION["errores"] = [];

        //validar duplicados
        if ($idPokemon1 == $idPokemon2 || $idPokemon1 == $idPokemon3 || $idPokemon2 == $idPokemon3) {
            $errores["repetidos"][] = "No puedes seleccionar Pokemon repetidos";
            header('Location: index.php?tabla=equipoPokemon&accion=crear');
            $error = true;
            $errores["repetidos"];
            
        }

        $crear = null;
        if (!$error) {
            $crear = $this->model->crear($idUsuario, $idPokemon1, $idPokemon2, $idPokemon3, $order1, $order2, $order3);
        }

        if ($crear) {
            header("location:index.php?tabla=equipoPokemon&accion=crear"); 
            exit();
        } else {
            $_SESSION["errores"]= $errores;
            header("location:index.php?tabla=equipoPokemon&accion=crear&error=true");
            exit();
        }
    }
}
