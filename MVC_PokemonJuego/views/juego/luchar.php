<?php
require_once "controllers/JuegoController.php";
require_once "assets/php/funciones.php";

$equipoUsuarioSesion = "";
$usuarioRival = "";
$equipoRival = "";

if(isset($_REQUEST["idRival"])){
    unset($_SESSION["rival"]);
    unset($_SESSION["jugador"]);
    unset($_SESSION["ganador"]);
}


if (!isset($_SESSION["rival"]) && !isset($_SESSION["jugador"])) {
    $controladorJuego = new JuegoController();
    $idRivalSelect = isset($_REQUEST["idRival"]) ? $_REQUEST["idRival"] : "";

    $equipoUsuarioSesion = $controladorJuego->devolverEquipo($_SESSION["usuario"]->id);

    $equipoRival = $controladorJuego->devolverEquipo($idRivalSelect);
    $usuarioRival = $controladorJuego->devolverRival($idRivalSelect);

    //Calcular poder del equipo ususario

    for ($i = 0; $i < count($equipoUsuarioSesion); $i++) {
        $equipoUsuarioSesion[$i]->poder = calcularPuntuacion($equipoUsuarioSesion[$i], $equipoRival[$i]->tipo);
    }

    //Calcular poder del equipo rival

    for ($i = 0; $i < count($equipoRival); $i++) {
        $equipoRival[$i]->poder = calcularPuntuacion($equipoRival[$i], $equipoUsuarioSesion[$i]->tipo);
    }

    //Recogemos los datos de los ganadores
    $_SESSION["ganador"] = calcularGanador($equipoUsuarioSesion, $equipoRival);

    $_SESSION["rival"]["equipo"] = $equipoRival;
    $_SESSION["jugador"]["equipo"] = $equipoUsuarioSesion;
    $_SESSION["rival"]["datos"] = $usuarioRival;
}




$visibilidad = "";
$mensaje = "";



?>



<main id="contenedor_main">

    <div id="contenedor_listar">
        <!--ESTE DIV CONTIENE LOS 2 CONTENEDORES DE EQUIPO -->
        <?php if (isset($_REQUEST["idRival"])): ?>
        <div id="contenedor2divs">
            <!--Inicio CONTENDOR EQUIPO USUARIO SESION--->
            <div id="contenido">
                <div>
                    <h1 class="titulo">Tu equipo</h1>
                </div>
                <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                    <?= $mensaje ?>
                </div>
                <table class="table-list table-light table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Pokemon</th>
                            <th scope="col">Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipoUsuarioSesion as $pokemon):
                            $id = $pokemon->id;
                        ?>
                            <tr>
                                <td><?= $pokemon->nombre ?></td>
                                <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!--CONTENDOR EQUIPO RIVAL--->
            <div id="contenido">
                <div>
                    <h1 class="titulo">EQUIPO de <?= $usuarioRival->usuario ?></h1>
                </div>

                <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                    <?= $mensaje ?>
                </div>

                <table class="table-list table-light table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Pokemon</th>
                            <th scope="col">Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipoRival as $pokemon):
                            $id = $pokemon->id;
                        ?>
                            <tr>
                                <td><?= $pokemon->nombre ?></td>
                                <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <!--TERMINA AQUI CONTENEDOR EQUIPO RIVAL-->
        </div>
        <!--div luchar-->
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="luchar" name="luchar">

            </form>
        </div>
        <!--boton luchar-->
        <?php endif; ?>
        <!---aqui temiran contedor 2 divs-->

       


        <div>
            <a href="index.php?tabla=juego&accion=seleccionRival">Volver al Menú</a>
        </div>

        <!------------------ PRIMER COMBATE------------------------------------->

        <?php if ((isset($_REQUEST["luchar"]) ? $_REQUEST["luchar"] : "") || isset($_REQUEST["primerCombate"])): ?>
            <div id="contenedor__lucha" style="border: 1px solid black; padding: 10px;">
                <h1>Empieza el combate</h1>
                <?php ?>

                <div id="fichaPokemon">
                    <h1>Tu pokemon</h1>
                    <div>
                        <?php if(isset($_REQUEST["primerCombate"]) && $_SESSION["ganador"]["ronda1"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][0]->imagen?>/<?= $_SESSION["jugador"]["equipo"][0]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["primerCombate"]) && $_SESSION["ganador"]["ronda1"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][0]->imagen?>/<?= $_SESSION["jugador"]["equipo"][0]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][0]->imagen?>/<?= $_SESSION["jugador"]["equipo"][0]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["jugador"]["equipo"][0]->nombre ?> <br>
                            Ataque: <?= $_SESSION["jugador"]["equipo"][0]->ataque ?><br>
                            Defensa: <?= $_SESSION["jugador"]["equipo"][0]->defensa ?><br>
                            Tipo: <?= $_SESSION["jugador"]["equipo"][0]->tipo ?><br>
                            Nivel: <?= $_SESSION["jugador"]["equipo"][0]->nivel ?><br>
                            <?php if(isset($_REQUEST["primerCombate"])): ?>
                            Poder Total: <?= $_SESSION["jugador"]["equipo"][0]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                </div>

                <div>
                    <h1>VS</h1>
                </div>
                 
                <div id="fichaPokemon">
                    <h1>Pokemon Rival</h1>
                    <div>
                        <?php if(isset($_REQUEST["primerCombate"]) && $_SESSION["ganador"]["ronda1"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][0]->imagen?>/<?= $_SESSION["rival"]["equipo"][0]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["primerCombate"]) && $_SESSION["ganador"]["ronda1"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][0]->imagen?>/<?= $_SESSION["rival"]["equipo"][0]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][0]->imagen?>/<?= $_SESSION["rival"]["equipo"][0]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["rival"]["equipo"][0]->nombre ?> <br>
                            Ataque: <?= $_SESSION["rival"]["equipo"][0]->ataque ?><br>
                            Defensa: <?= $_SESSION["rival"]["equipo"][0]->defensa ?><br>
                            Tipo: <?= $_SESSION["rival"]["equipo"][0]->tipo ?><br>
                            Nivel: <?= $_SESSION["rival"]["equipo"][0]->nivel ?><br>
                            <?php if(isset($_REQUEST["primerCombate"])): ?>
                            Poder Total: <?= $_SESSION["rival"]["equipo"][0]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

            </div>
        <?php endif; ?>


        <!--------------- SEGUNDO COMBATE ---------------------->

        <?php if (isset($_REQUEST["segundoCombate"]) || isset($_REQUEST["pasarASegundoCombate"])): ?>
            <div id="contenedor__lucha" style="border: 1px solid black; padding: 10px;">
                <h1>Empieza el combate</h1>
                <?php ?>

                <div id="fichaPokemon">
                    <h1>Tu pokemon</h1>
                    <div>
                        <?php if(isset($_REQUEST["segundoCombate"]) && $_SESSION["ganador"]["ronda2"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][1]->imagen?>/<?= $_SESSION["jugador"]["equipo"][1]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["segundoCombate"]) && $_SESSION["ganador"]["ronda2"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][1]->imagen?>/<?= $_SESSION["jugador"]["equipo"][1]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][1]->imagen?>/<?= $_SESSION["jugador"]["equipo"][1]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["jugador"]["equipo"][1]->nombre ?> <br>
                            Ataque: <?= $_SESSION["jugador"]["equipo"][1]->ataque ?><br>
                            Defensa: <?= $_SESSION["jugador"]["equipo"][1]->defensa ?><br>
                            Tipo: <?= $_SESSION["jugador"]["equipo"][1]->tipo ?><br>
                            Nivel: <?= $_SESSION["jugador"]["equipo"][1]->nivel ?><br>
                            <?php if(isset($_REQUEST["segundoCombate"])): ?>
                            Poder Total: <?= $_SESSION["jugador"]["equipo"][1]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                </div>

                <div>
                    <h1>VS</h1>
                </div>
                 
                <div id="fichaPokemon">
                    <h1>Pokemon Rival</h1>
                    <div>
                        <?php if(isset($_REQUEST["segundoCombate"]) && $_SESSION["ganador"]["ronda2"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][1]->imagen?>/<?= $_SESSION["rival"]["equipo"][1]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["segundoCombate"]) && $_SESSION["ganador"]["ronda2"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][1]->imagen?>/<?= $_SESSION["rival"]["equipo"][1]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][1]->imagen?>/<?= $_SESSION["rival"]["equipo"][1]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["rival"]["equipo"][1]->nombre ?> <br>
                            Ataque: <?= $_SESSION["rival"]["equipo"][1]->ataque ?><br>
                            Defensa: <?= $_SESSION["rival"]["equipo"][1]->defensa ?><br>
                            Tipo: <?= $_SESSION["rival"]["equipo"][1]->tipo ?><br>
                            Nivel: <?= $_SESSION["rival"]["equipo"][1]->nivel ?><br>
                            <?php if(isset($_REQUEST["segundoCombate"])): ?>
                            Poder Total: <?= $_SESSION["rival"]["equipo"][1]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

            </div>
        <?php endif; ?>



        <!--------------- SEGUNDO COMBATE ---------------------->






        <!------------TERCER COMBATE ---------------------------->
        <?php if (isset($_REQUEST["tercerCombate"] ) || isset($_REQUEST["pasarATercerCombate"])): ?>
            <div id="contenedor__lucha" style="border: 1px solid black; padding: 10px;">
                <h1>Empieza el combate</h1>
                <?php ?>

                <div id="fichaPokemon">
                    <h1>Tu pokemon</h1>
                    <div>
                        <?php if(isset($_REQUEST["tercerCombate"]) && $_SESSION["ganador"]["ronda3"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][2]->imagen?>/<?= $_SESSION["jugador"]["equipo"][2]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["tercerCombate"]) && $_SESSION["ganador"]["ronda3"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][2]->imagen?>/<?= $_SESSION["jugador"]["equipo"][2]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["jugador"]["equipo"][2]->imagen?>/<?= $_SESSION["jugador"]["equipo"][2]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["jugador"]["equipo"][2]->nombre ?> <br>
                            Ataque: <?= $_SESSION["jugador"]["equipo"][2]->ataque ?><br>
                            Defensa: <?= $_SESSION["jugador"]["equipo"][2]->defensa ?><br>
                            Tipo: <?= $_SESSION["jugador"]["equipo"][2]->tipo ?><br>
                            Nivel: <?= $_SESSION["jugador"]["equipo"][2]->nivel ?><br>
                            <?php if(isset($_REQUEST["tercerCombate"])): ?>
                            Poder Total: <?= $_SESSION["jugador"]["equipo"][2]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                </div>

                <div>
                    <h1>VS</h1>
                </div>
                 
                <div id="fichaPokemon">
                    <h1>Pokemon Rival</h1>
                    <div>
                        <?php if(isset($_REQUEST["tercerCombate"]) && $_SESSION["ganador"]["ronda3"] == "pokemonRival"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][2]->imagen?>/<?= $_SESSION["rival"]["equipo"][2]->nombre?>_V.gif" alt="">
                        <?php elseif(isset($_REQUEST["tercerCombate"]) && $_SESSION["ganador"]["ronda3"] == "pokemonJugador"): ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][2]->imagen?>/<?= $_SESSION["rival"]["equipo"][2]->nombre?>_R.gif" alt="">
                        <?php else: ?>
                        <img src="<?= $_SESSION["rival"]["equipo"][2]->imagen?>/<?= $_SESSION["rival"]["equipo"][2]->nombre?>.gif" alt="">
                        <?php endif; ?>
                        <p>
                            Nombre: <?= $_SESSION["rival"]["equipo"][2]->nombre ?> <br>
                            Ataque: <?= $_SESSION["rival"]["equipo"][2]->ataque ?><br>
                            Defensa: <?= $_SESSION["rival"]["equipo"][2]->defensa ?><br>
                            Tipo: <?= $_SESSION["rival"]["equipo"][2]->tipo ?><br>
                            Nivel: <?= $_SESSION["rival"]["equipo"][2]->nivel ?><br>
                            <?php if(isset($_REQUEST["tercerCombate"])): ?>
                            Poder Total: <?= $_SESSION["rival"]["equipo"][2]->poder ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

            </div>
        <?php endif; ?>



        <!------------TERCER COMBATE ---------------------------->
        


        <?php if(isset($_REQUEST["luchar"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="Primer combate -Luchar " name="primerCombate">
            </form>
        </div>
        <?php endif; ?>

        <?php if(isset($_REQUEST["primerCombate"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="Pasar a Segundo Combate" name="pasarASegundoCombate">

            </form>
        </div>
        <?php endif; ?>

        <?php if(isset($_REQUEST["pasarASegundoCombate"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="Segundo Combate -Luchar" name="segundoCombate">

            </form>
        </div>
        <?php endif; ?>

        <?php if(isset($_REQUEST["segundoCombate"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="Tercer Combate" name="pasarATercerCombate">

            </form>
        </div>
        <?php endif; ?>

        <?php if(isset($_REQUEST["pasarATercerCombate"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=luchar" method="post">
                <input type="submit" value="Tercer Combate -Luchar" name="tercerCombate">
            </form>
        </div>
        <?php endif; ?>

        <?php if(isset($_REQUEST["tercerCombate"])): ?>
        <div class="botonLuchar">
            <form action="index.php?tabla=juego&accion=final" method="post">
                <input type="submit" value="Final" name="final">
            </form>
        </div>
        <?php endif; ?>


        
    </div>
</main>