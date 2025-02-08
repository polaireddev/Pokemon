<?php

require_once "controllers/juegoController.php";

$_SESSION["ganador"];
$mensaje = "";
$rival = $_SESSION["rival"]["datos"];
$nombreUsuario = $_SESSION["usuario"]->usuario;
$ganador = "";
$equipoGanador = "";
if (($_SESSION["ganador"]["ronda1"] == "pokemonJugador" && $_SESSION["ganador"]["ronda2"] == "pokemonJugador") ||
    ($_SESSION["ganador"]["ronda1"] == "pokemonJugador" && $_SESSION["ganador"]["ronda3"] == "pokemonJugador") ||
    ($_SESSION["ganador"]["ronda2"] == "pokemonJugador" && $_SESSION["ganador"]["ronda3"] == "pokemonJugador")
) {
    $mensaje = "¡Ha ganado {$nombreUsuario}!";
    $ganador = $_SESSION["usuario"];
    $equipoGanador = $_SESSION["jugador"]["equipo"];
} else {
    $mensaje =  "¡Ha ganado {$rival->usuario}!";
    $ganador = $rival;
    $equipoGanador = $_SESSION["rival"]["equipo"];
}


//PREPARAMOS LAS INSERCIONES DE PARTIDAS JUGADAS, GANADAS Y PERDIDAS
$controlador = new JuegoController();

//Añadir partida jugada al usuario
$pok = $controlador->sumarPartidas($_SESSION["usuario"]->id);

if($pok != false){
    $_SESSION["pok"] = $pok;
}

if ($ganador->id == $_SESSION["usuario"]->id) {
    $evol = $controlador->sumarPartidasGanadas($_SESSION["usuario"]->id);

    if($evol != false){
        $_SESSION["evolucion"] = $evol;
    }


} else {
    $controlador->sumarPartidasPerdidas($_SESSION["usuario"]->id);
}

?>



<main id="contenedor_main_lucha_final">



    <div class="contenidoFinal">
        <h1><?= $mensaje  ?></h1>

        <div id="fichasEquipoGanador">
            <div id="fichaPokemon_lucha_final">
                <h1> <?= $equipoGanador[0]->nombre ?></h1>
                <div>
                    <img src="<?= $equipoGanador[0]->imagen ?>/<?= $equipoGanador[0]->nombre ?>.gif" alt="">
                    <p>

                        Ataque: <?= $equipoGanador[0]->ataque ?><br>
                        Defensa: <?= $equipoGanador[0]->defensa ?><br>
                        Tipo: <?= $equipoGanador[0]->tipo ?><br>
                        Nivel: <?= $equipoGanador[0]->nivel ?><br>
                        Poder Total: <?= $equipoGanador[0]->poder ?>
                    </p>
                </div>

            </div>

            <div id="fichaPokemon_lucha_final">
                <h1><?= $equipoGanador[1]->nombre ?></h1>
                <div>
                    <img src="<?= $equipoGanador[1]->imagen ?>/<?= $equipoGanador[1]->nombre ?>.gif" alt="">
                    <p>
                        Ataque: <?= $equipoGanador[1]->ataque ?><br>
                        Defensa: <?= $equipoGanador[1]->defensa ?><br>
                        Tipo: <?= $equipoGanador[1]->tipo ?><br>
                        Nivel: <?= $equipoGanador[1]->nivel ?><br>
                        Poder Total: <?= $equipoGanador[1]->poder ?>
                    </p>
                </div>

            </div>

            <div id="fichaPokemon_lucha_final">
                <h1><?= $equipoGanador[2]->nombre ?></h1>
                <div>
                    <img src="<?= $equipoGanador[2]->imagen ?>/<?= $equipoGanador[2]->nombre ?>.gif" alt="">
                    <p>
                        Ataque: <?= $equipoGanador[2]->ataque ?><br>
                        Defensa: <?= $equipoGanador[2]->defensa ?><br>
                        Tipo: <?= $equipoGanador[2]->tipo ?><br>
                        Nivel: <?= $equipoGanador[2]->nivel ?><br>
                        Poder Total: <?= $equipoGanador[2]->poder ?>
                    </p>
                </div>

            </div>
        </div>


        <div id="div_volver_menu_lucha_final">
            <a href="index.php">Volver al Menú</a>
        </div>

    </div>
</main>