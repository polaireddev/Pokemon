<?php
require_once "models/pokemonModel.php";
require_once "controllers/equipoController.php";
require_once "assets/php/funciones.php";


class pokemonController
{

    private $model;

    public function __construct()
    {
        $this->model = new pokemonModel();
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

    public function devolverPokemonsLvl1()
    {

        return $this->model->devolverPokemonsLvl1Model();
    }

    public function listar($comprobarSiEsBorrable = false)
    {
        $pokemons = $this->model->readAll();
        if ($comprobarSiEsBorrable) {
            foreach ($pokemons as $pokemon) {
                $pokemon->esBorrable = $this->esBorrable($pokemon); //le vamos pasando 1x1 todos los usurio para verificar si estan marcados como true
            }
        }
        return $pokemons;
    }

    public function listarEvolucionesPosibles($id)
    {
        $pokemon = $this->model->read($id);
        $pokemons = $this->model->listarEvolucionesPosiblesModel($pokemon->tipo, $pokemon->nivel);
        return $pokemons;
    }

    

    public function editarEvolucion($id, $id_evolucion): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->editEvolution($id, $id_evolucion);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            //$_SESSION["datos"] = $arrayPokemon;
            $redireccion = "location:index.php?accion=editar&tabla=pokemon&evento=modificarEvolucion&id={$id}&error=true";
        } else {

            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            $redireccion = "location:index.php?accion=listar&tabla=pokemon&id={$id}";
        }
        header($redireccion);
        exit();
    }

    //METODO DE BUSCAR HAY QUE ADAPTARLO A POKEMON
    public function buscar(string $campo, string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $pokemons = $this->model->search($campo, $metodo, $texto);

        if ($comprobarSiEsBorrable) {
            foreach ($pokemons as $pokemon) {
                $pokemon->esBorrable = $this->esBorrable($pokemon);
            }
        }
        return $pokemons;
    }



   


    
    
}


