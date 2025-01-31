<?php
require_once "controllers/userPokemonController.php";

$controlador = new userPokemonController();
$pokemons = $controlador->listarPokemonsLvlBajo($_SESSION["usuario"]->id);

?>



<main id=contenedor_main>
<div id="contenedor_pokemons">

    <?php foreach ($pokemons as $pokemon):?>
       
        <div id="contenedor_pokemon"  >
            <form action="index.php?tabla=userPokemon&accion=confirmarEvolucion" method="post" >

            <div id="fichaPokemon">
                <input type="hidden" name="idPokemon" value="<?=$pokemon->id?>">
                <button type="submit" style="border: none; background: none; padding: 0;">
                    <img class="imagenes" src="<?=$pokemon->imagen?>/<?=$pokemon->nombre?>.gif" alt="<?=$pokemon->nombre?>">
                </button>
                <p>
                    Nombre: <?=$pokemon->nombre?> <br>
            </div>

            </form>
        </div>

    <?php endforeach ?>   

</div>
</main>