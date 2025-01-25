<?php
require_once "controllers/pokemonController.php";

$controlador = new PokemonController();
$pokemons = $controlador->listar(comprobarSiEsBorrable: true);
$visibilidad = "hidden";
?>
<div  id="contenedor_main">



    <main id="contenedor_listar">
    <div>
        <h1 class="h3">Listar Pokemons</h1>
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
                        <th scope="col">Eliminar</th>
                        <th scope="col">Ver</th>
                        <th scope="col">Modificar Evolución</th>
                        <th scope="col">Modificar Imagenes</th>
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
                            <td>
                            <?php
                                $disable = "";
                                $ruta = "index.php?tabla=pokemon&accion=borrar&id={$id}";
                                if (isset($pokemon->esBorrable) && $pokemon->esBorrable == false) {
                                    $disable = "disabled";
                                    $ruta = "#";
                                }
                                ?>
                                <button class="btn-listar-borrar <?= $disable ?>"><a href="<?= $ruta ?>">Borrar</a></button>
                            </td>
                            <td>
                                <button class="btn-listar-ver"><a href="index.php?tabla=pokemon&accion=ver&id=<?=$id?>"> Ver</a></button>
                            </td>
                            <td>
                                <button class="btn-option"><a href="index.php?tabla=pokemon&accion=modificarEvolucion&id=<?=$id?>&nombre=<?=$pokemon->nombre?>">Evolución</a></button>
                            </td>
                            <td>
                                <button class="btn-option"><a href="index.php?tabla=pokemon&accion=modificarImagenes&id=<?=$id?>&nombre=<?=$pokemon->nombre?>">Imagenes</a></button>
                            </td>
                            <!--<td><a class="btn btn-success" href="index.php?tabla=user&accion=editar&id= //$id "><i class="fa fa-pencil"></i>Editar</a></td>-->
                        </tr>
                        <?php
                    endforeach;

                    ?>
                </tbody>
            </table>
                
            
            
            <?php
        endif;
        ?>
    </div>
    
</div>

</main>

</div>
