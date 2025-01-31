<?php
require_once "assets/php/funciones.php";
require_once "models/userModel.php";
require_once "controllers/pokemonController.php";
require_once "controllers/userPokemonController.php";
require_once "controllers/equipoController.php";

class UsersController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    





//VER USUARIO POR ID
    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

//LISTAR TODOS LOS USUARIOS
    public function listar($comprobarSiEsBorrable = false) //lo ponemos como false para cuando lo llamemmos en la vista lo ponemso en true y asi poder ejecutar el la condicion
    {
        $users = $this->model->readAll();
        return $users;
    }


    function sumarPartidas($idJugador){
        $this->model->sumarPartidas($idJugador);

        $numPartidas = $this->model->verPartidasJugadas($idJugador);
        if($numPartidas%10==0){
            $controladorUserPokemon = new userPokemonController();
            $controladorUserPokemon->insertarPokemonUsuario($idJugador);
        }
    }

    function sumarPartidasGanadas($idJugador){
        $this->model->sumarPartidasGanadas($idJugador);

        $numPartidas = $this->model->verPartidasGanadas($idJugador);

        //Si se inserta una evolucion devolvemos true, sino false
        if($numPartidas%10==0){
            $this->model->insertarEvolucion($idJugador);
           
        }
    }

    function sumarPartidasPerdidas($idJugador){
        $this->model->sumarPartidasPerdidas($idJugador);

        
    }











}
