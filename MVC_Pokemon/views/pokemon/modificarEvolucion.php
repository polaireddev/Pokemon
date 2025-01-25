<?php
require_once "assets/php/funciones.php";
require_once "controllers/pokemonController.php";

$pokemonControlador = new pokemonController();
$pokemonModificarId = $_REQUEST["id"];
$pokemons = $pokemonControlador->listarEvolucionesPosibles($pokemonModificarId);



?>


<main id="mainModificarEvolucion">

    <h1>Evoluciones para: <?= $_REQUEST["nombre"] ?></h1>

    <form action="index.php?tabla=pokemon&accion=guardar&evento=modificarEvolucion&nombre=<?=$_REQUEST["nombre"]?>&id=<?= $pokemonModificarId?>" method="post">

        <div>
            <label for="idPokemonEvolucion">Pokemon </label>
            <select id="idPokemonEvolucion" name="idPokemonEvolucion">
                <option value="">---- Elije el Pokemon al que debe Evolucionar ----</option>
                <option value="">---- Sin evolucion ----</option>

                <?php 
                foreach($pokemons as $pokemon):
                   
                    echo "<option value='{$pokemon->id}'> id: {$pokemon->id} - {$pokemon->nombre} - {$pokemon->tipo} - {$pokemon->nivel}</option>";
                
                endforeach; ?>
            </select>
        </div>
         <input type="submit" value="Enviar">

    </form>
    <a href="index.php?tabla=pokemon&accion=listar">Volver</a>


</main>

