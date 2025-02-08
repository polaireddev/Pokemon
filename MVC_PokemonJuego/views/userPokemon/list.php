<?php
require_once "controllers/userPokemonController.php";

$controlador = new userPokemonController();
$pokemons = $controlador->listar($_SESSION["usuario"]->id);
$visibilidad = "hidden";
?>
<div id="contenedor_main">



    <main id="contenedor_listar_listar">

        <div>
            <h1 class="titulo">Tus Pokemons</h1>
        </div>

        <div id="contenido_fichas_listar">
            <?php foreach ($pokemons as $pokemon): ?>
                <div id="fichaPokemon_listar">
                    <h2><?= $pokemon->nombre ?></h2>
                    <img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="">
                    <p>
                        ID: <?= $pokemon->id ?> <br>
                        Ataque: <?= $pokemon->ataque ?><br>
                        Defensa: <?= $pokemon->defensa ?><br>
                        Tipo: <?= $pokemon->tipo ?><br>
                        Nivel: <?= $pokemon->nivel ?><br>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="div_volver_menu_evolucionar_listar">
            <a href="index.php">Volver al Menú</a>
        </div>

    </main>

</div>