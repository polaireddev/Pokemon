<?php
require_once "models/pokemonModel.php";
require_once "controllers/equipoController.php";


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

    public function editarEvolucion($id, $id_evolucion): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }



        //campos NO VACIOS
        /*$arrayNoNulos = ["password", "usuario"];
    $nulos = HayNulos($arrayNoNulos, $arrayUser);
    if (count($nulos) > 0) {
        $error = true;
        for ($i = 0; $i < count($nulos); $i++) {
            $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
        }
    }
    
    //CAMPOS UNICOS
    $arrayUnicos = [];
    if ($arrayUser["usuario"] != $arrayUser["usuarioOriginal"]) $arrayUnicos[] = "usuario";

    foreach ($arrayUnicos as $CampoUnico) {
        if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
            $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayUser[$CampoUnico]}  ya existe";
            $error = true;
        }
    }*/



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


    public function borrar(int $id):void{

        //parametros para deshabilitar boton 
        $pokemon= $this->ver($id);
        $borrado= $this->model->delete($id); 


        $redireccion= "location:index.php?accion=listar&tabla=pokemon&evento=borrar&id={$id}&nombre={$pokemon->nombre}"; //datos para confirmar eldelete
        if($borrado==false){
            $redireccion.="&error=true";
            header($redireccion);
        exit();
        }
        
    
    }

    private function esBorrable(stdClass $pokemon): bool //le pasamos como paraemtro el usuario q queremos verificar
    {
        $borrable = true;
        $equipoPokemon = new equipoController();
        
        // si ese usuario está en algún proyecto, No se puede borrar.
        if (count($this->buscar("id_evolucion", "igualA", $pokemon->id)) > 0) 
            $borrable = false; //aqui marcamos si es borrable como falso o no

        if (count($equipoPokemon->buscar("pokemon_id", "igualA", $pokemon->id)) > 0) 
            $borrable = false; //aqui marcamos si es borrable como falso o no

        return $borrable;
    }


    
    
}


