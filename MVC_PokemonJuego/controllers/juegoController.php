<?php

require_once "controllers/usersController.php";
require_once "controllers/equipoController.php";

class JuegoController{ 


    function devolverRivales(){

        $controladorUsuarios = new UsersController();

        //Guardamos y devolvemos la lista de los rivales
        $arrayRivales = $controladorUsuarios->listar();

        //Depuramos que no sean
        $rivales = [];
        foreach($arrayRivales as $user){
            if($user->administrador == false){
            array_push($rivales, $user);
            }
        }

        return $rivales;

    }

    function devolverRival($idRival){

        $controladorUsuarios = new UsersController();

        //Guardamos y devolvemos la lista de los rivales
        return $controladorUsuarios->ver($idRival);

    }


    function devolverEquipo($idJugador){
        $controladorEquipo= new equipoController();

        $equipoPokemon = $controladorEquipo->listar($idJugador);

        return $equipoPokemon;
    }

    function sumarPartidas($idJugador){
        $controladorUsuarios = new UsersController();

        $controladorUsuarios->sumarPartidas($idJugador);
    }

    function sumarPartidasGanadas($idJugador){
        $controladorUsuarios = new UsersController();

        $controladorUsuarios->sumarPartidasGanadas($idJugador);
    }

    function sumarPartidasPerdidas($idJugador){
        $controladorUsuarios = new UsersController();

        $controladorUsuarios->sumarPartidasPerdidas($idJugador);
    }


    public function devolverUsuarioSesion($usuarioId){
        $userControl = new UsersController();

        $userControl->ver($usuarioId);
    }


}

?>