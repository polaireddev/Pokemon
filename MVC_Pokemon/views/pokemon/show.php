<?php
require_once "controllers/pokemonController.php";
if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}

$pokemonEvoluciona = "";
$id = $_REQUEST['id'];
$controlador = new pokemonController();
$pokemon = $controlador->ver($id);
if ($pokemon->id_evolucion != null) {
    $pokemonEvoluciona = $controlador->ver($pokemon->id_evolucion);
}
?>
<main>
    <div>
        <h1 class="h3">Ver Pokemon</h1>
    </div>
    <div id="contenido">
        <div>
            <div>
                <h5>ID: <?= $pokemon->id ?></h5>

                <div>
                    <img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="">
                    <p>
                        Nombre: <?= $pokemon->nombre ?> <br>
                        Ataque: <?= $pokemon->ataque ?><br>
                        Defensa: <?= $pokemon->defensa ?><br>
                        Tipo: <?= $pokemon->tipo ?><br>
                        Nivel: <?= $pokemon->nivel ?><br>
                    </p>
                </div>


                <?php if ($pokemonEvoluciona != null): ?>


                    <div>
                        <img src="<?= $pokemonEvoluciona->imagen ?>/<?= $pokemonEvoluciona->nombre ?>.gif" alt="">
                        <p>
                            Nombre: <?= $pokemonEvoluciona->nombre ?> <br>
                            Ataque: <?= $pokemonEvoluciona->ataque ?><br>
                            Defensa: <?= $pokemonEvoluciona->defensa ?><br>
                            Tipo: <?= $pokemonEvoluciona->tipo ?><br>
                            Nivel: <?= $pokemonEvoluciona->nivel ?><br>
                        </p>

                    </div>
                <?php endif ?>

                <a href="index.php?tabla=pokemon&accion=listar">Volver a Inicio</a>
            </div>
        </div>
</main>