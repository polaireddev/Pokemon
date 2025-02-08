<?php
require_once "controllers/userPokemonController.php";

$controlador = new userPokemonController();
$pokemonUsuario = "";
$pokemonEvolucion = "";

//Primera pasada de confirmación
if (isset($_REQUEST["idPokemon"])) {
    $pokemonUsuario = $controlador->verPokemon($_REQUEST["idPokemon"]);
    $pokemonEvolucion = $controlador->verPokemon($pokemonUsuario->id_evolucion);
}
//Segunda pasada, ya confirmada la evolución
if (isset($_REQUEST["confirmarEvolucion"])) {
    $pokemonUsuario = $controlador->verPokemon($_REQUEST["idPokemonUsuario"]);
    $pokemonEvolucion = $controlador->verPokemon($_REQUEST["idPokemonEvolucionado"]);

    $controlador->modificarEvolucion($pokemonUsuario->id, $pokemonEvolucion->id, $_SESSION["usuario"]->id);
}



?>



<main id=contenedor_main>
    <div id="contenido_evolucionar">
        <!--PREGUNTAMOS SI QUEREMOS CONFIRMAR LA EVOLUCIÓN -->
        <?php if (!isset($_REQUEST["confirmarEvolucion"])): ?>
            <div id="contenido_evolucionar_confirmar">
                <div id="fichaPokemon_evolucionar">
                    <div>
                        <img src="<?= $pokemonUsuario->imagen ?>/<?= $pokemonUsuario->nombre ?>.gif" alt="">
                        <p>
                            Nombre: <?= $pokemonUsuario->nombre ?> <br>
                            Ataque: <?= $pokemonUsuario->ataque ?><br>
                            Defensa: <?= $pokemonUsuario->defensa ?><br>
                            Tipo: <?= $pokemonUsuario->tipo ?><br>
                            Nivel: <?= $pokemonUsuario->nivel ?><br>
                        </p>
                    </div>
                </div>



                <div class="flecha_evolucionar">
                    ⇒
                </div>

                <div id="fichaPokemonEvolucion_evolucionar">

                    <img src="<?= $pokemonEvolucion->imagen ?>/<?= $pokemonEvolucion->nombre ?>.gif" alt="">
                    <p>
                        Nombre: <?= $pokemonEvolucion->nombre ?> <br>
                        Ataque: <?= $pokemonEvolucion->ataque ?><br>
                        Defensa: <?= $pokemonEvolucion->defensa ?><br>
                        Tipo: <?= $pokemonEvolucion->tipo ?><br>
                        Nivel: <?= $pokemonEvolucion->nivel ?><br>
                    </p>

                </div>
            </div>
            <div class="boton_confirmar_evolucion">
                <form action="index.php?tabla=userPokemon&accion=confirmarEvolucion&idPokemonEvolucionado=<?= $pokemonEvolucion->id ?>&idPokemonUsuario=<?= $pokemonUsuario->id ?>" method="post">
                    <input type="submit" value="Confirmar Evolución" name="confirmarEvolucion">
                </form>
            </div>
        <?php endif; ?>

        <!-- UNA VEZ CONFIRMADA LA EVOLUCIÓN MOSTRAMOS EL POKEMON EVOLUCIONADO -->

        <?php if (isset($_REQUEST["confirmarEvolucion"])): ?>

            <div>
                <div id="fichaPokemonEvolucion">
                    <h2>Tu <?= $pokemonUsuario->nombre ?> ha evolucionado a <?= $pokemonEvolucion->nombre ?></h2>
                    <img src="<?= $pokemonEvolucion->imagen ?>/<?= $pokemonEvolucion->nombre ?>.gif" alt="">
                    <p>
                        Nombre: <?= $pokemonEvolucion->nombre ?> <br>
                        Ataque: <?= $pokemonEvolucion->ataque ?><br>
                        Defensa: <?= $pokemonEvolucion->defensa ?><br>
                        Tipo: <?= $pokemonEvolucion->tipo ?><br>
                        Nivel: <?= $pokemonEvolucion->nivel ?><br>
                    </p>
                </div>

            </div>


        <?php endif; ?>

    </div>
    <div id="div_volver_menu_confirmar_evolucion">
        <a href="index.php">Volver al Menú</a>
    </div>
</main>