<?php
require_once "controllers/userPokemonController.php";

$controlador = new userPokemonController();
$pokemons = $controlador->listar($_SESSION["usuario"]->id);
$visibilidad = "hidden";
?>
<div  id="contenedor_main">



    <main id="contenedor_listar">
    <div>
        <h1 class="titulo">Listar Pokemons</h1>
    </div>
    <div id="contenido">
        <?php

        if (count($pokemons) <= 0):
            echo "No hay Datos a Mostrar";
        else: ?>
            <?php
            if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") { //VER QUE HACE ESTO, DE DONDE VIENE
                $visibilidad = "visible";
                $clase = "alert alert-success";
                //Mejorar y poner el nombre/usuario
                $mensaje = "El pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}Borrado correctamente";

                if (isset($_REQUEST["error"])) {
                    $clase = "alert alert-danger ";
                    $mensaje = "ERROR!!! No se ha podido borrar el pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}  Borrado correctamente";
                }
            }
            ?>

            <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                <?= $mensaje ?>
            </div>

            
            
            <table class="table-list table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Imagen</th>
                        <th scope="col">ID</th>
                        <th scope="col">Pokemon</th>
                        <th scope="col">Ataque</th>
                        <th scope="col">Defensa</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Evolucion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pokemons as $pokemon):
                        $id = $pokemon->id;
                        ?>
                        <tr>
                            <td> <img src="<?=$pokemon->imagen?>/<?=$pokemon->nombre ?>.gif" alt=""></td>
                            <th scope="row"><?= $pokemon->id ?></th>
                            <td><?= $pokemon->nombre ?></td>
                            <td><?= $pokemon->ataque ?></td>
                            <td><?= $pokemon->defensa ?></td>
                            <td><?= $pokemon->tipo ?></td>
                            <td><?= $pokemon->nivel ?></td>
                            <td><?= $pokemon->id_evolucion ?></td>
                        </tr>
                        <?php
                    endforeach;

                    ?>
                </tbody>
            </table>
                
            
            
            <?php
        endif;
        ?>
    <div id="div_volver_menu_evolucionar_listar">
        <a href="index.php">Vovler al Menú</a>
    </div>
    
</div>

</main>

</div>
