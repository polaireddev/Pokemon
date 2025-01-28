
<?php
require_once "controllers/pokemonController.php";
require_once "controllers/userPokemonController.php";
require_once "controllers/equipoController.php";
//recoger datos
if (!isset($_REQUEST["idPokemon1"], $_REQUEST["idPokemon2"], $_REQUEST["idPokemon2"])) {
    header('Location:index.php?tabla=equipoPokemon&accion=crear');
    exit();
}


//recojo los datos
$idUsuario = ($_REQUEST["idUsuarioSesion"]) ?? ""; 
$idPokemon1 = ($_REQUEST["idPokemon1"]) ?? "";
$idPokemon2 = ($_REQUEST["idPokemon2"]) ?? "";
$idPokemon3 = ($_REQUEST["idPokemon3"]) ?? "";
$_SESSION["errores"] = [];


$controladorUserPokemon = new userPokemonController(); //pokemons disponibles todos lo que puede llegar a tener
$controladorEquipo = new equipoController(); //los pokemons en especifico que tiene, es decir el equipo de 3



if ($_REQUEST["evento"] == "crear") {
    $controladorEquipo->crear($idUsuario, $idPokemon1, $idPokemon2, $idPokemon3);


}





