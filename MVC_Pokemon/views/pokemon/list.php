<?php
require_once "controllers/pokemonController.php";

$controlador = new PokemonController();
$pokemons = $controlador->listar();
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
                $mensaje = "El pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}, usuario:{$_REQUEST['usuario']} Borrado correctamente";

                if (isset($_REQUEST["error"])) {
                    $clase = "alert alert-danger ";
                    $mensaje = "ERROR!!! No se ha podido borrar el pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}, pokemon:{$_REQUEST['usuario']} Borrado correctamente";
                }
            }
            ?>
            <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                <?= $mensaje ?>
            </div>
            <center>
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
                                <button class="btn-listar-borrar"><a href="index.php?tabla=pokemon&accion=borrar&id=<?=$id?>">Borrar</a></button>
                            </td>
                            <td>
                                <button class="btn-listar-ver"><a href="index.php?tabla=pokemon&accion=ver&id=<?=$id?>"> Ver</a></button>
                            </td>
                            <td>
                                <button class="btn-listar-ver"><a href="index.php?tabla=pokemon&accion=modificarEvolucion&id=<?=$id?>&nombre=<?=$pokemon->nombre?>">Modificar Evolución</a></button>
                            </td>
                            <!--<td><a class="btn btn-success" href="index.php?tabla=user&accion=editar&id= //$id "><i class="fa fa-pencil"></i>Editar</a></td>-->
                        </tr>
                        <?php
                    endforeach;

                    ?>
                </tbody>
            </table>
                
            </center>
            
            <?php
        endif;
        ?>
        </div>
    
    </div>

</main>

</div>
