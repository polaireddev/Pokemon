<?php
require_once "controllers/userPokemonController.php";

$controlador = new userPokemonController();
$pokemons = $controlador->listarPokemonsLvlBajo($_SESSION["usuario"]->id);

?>



<main id=contenedor_main>
    <div id="contenedor_pokemons">

        <?php if (count($pokemons) == 0): ?>
            <div id="no_pokemons_evolucion">
                <h2>No tienes pokemons para evolucionar</h2>
            </div>
            <?php else: ?>
            <?php foreach ($pokemons as $pokemon): ?>

                <div id="contenedor_pokemon">
                    <form action="index.php?tabla=userPokemon&accion=confirmarEvolucion" method="post">

                        <div id="fichaPokemon">
                            <input type="hidden" name="idPokemon" value="<?= $pokemon->id ?>">
                            <button type="submit" style="border: none; background: none; padding: 0;">
                                <img class="imagenes" src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="<?= $pokemon->nombre ?>">
                            </button>
                            <p>
                                Nombre: <?= $pokemon->nombre ?> <br>
                        </div>

                    </form>
                </div>

            <?php endforeach ?>
        <?php endif; ?>
    </div>
    <div id="div_volver_menu_evolucionar">
        <a href="index.php">Volver al Menú</a>
    </div>
</main>