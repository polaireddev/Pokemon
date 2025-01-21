<?php
require_once "models/pokemonModel.php";


class pokemonController
{

    private $model;

    public function __construct()
    {
        $this->model = new pokemonModel();
    }

    public function devolverPokemonsLvl1()
    {

        return $this->model->devolverPokemonsLvl1Model();
    }

    public function listar()
    {
        $pokemons = $this->model->readAll();
        return $pokemons;
    }

    public function crear(array $arrayPokemon, $arrayImagenes): int
    {
        $error = false;
        $errores = [];

        /*
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "ataque", "defensa", "tipo", "nivel"];
        $nulos = HayNulos($arrayNoNulos, $arrayPokemon); // Me devuele un array de nulo y aqui simplemente los recorre le añade un mensaje mediante un array asociativo
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["nombre"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayPokemon[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayPokemon[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }

        //PATRON DE USUARIO (LETRAS Y NUMEROS)
        if (!validarUsuario($arrayPokemon["nombre"])) {
            $errores["nombre"][] = "Carácteres del nombre incorrectos";
            $error = true;
        }
*/
        $id = null;
        if (!$error) {
            $id = $this->model->insert($arrayPokemon);
        }

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayPokemon;
            header("location:index.php?tabla=pokemon&accion=crear&error=true&id={$id}"); //CAMBIAR ESTO
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);

            return $id;
        }
    }
}
