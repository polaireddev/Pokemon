<?php
require_once "controllers/usersController.php";

$controlador = new UsersController();
$users = $controlador->listar(comprobarSiEsBorrable: true);
$visibilidad = "hidden";
?>
<main id="contenedor_listar">
    <div>
        <h1 class="h3">Listar usuario</h1>
    </div>
    <div id="contenido">
        <?php

        if (count($users) <= 0):
            echo "No hay Datos a Mostrar";
        else: ?>
            <?php
            if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") { //VER QUE HACE ESTO, DE DONDE VIENE
                $visibilidad = "visible";
                $clase = "alert alert-success";
                //Mejorar y poner el nombre/usuario
                $mensaje = "El usuario con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}, usuario:{$_REQUEST['usuario']} Borrado correctamente";

                if (isset($_REQUEST["error"])) {
                    $clase = "alert alert-danger ";
                    $mensaje = "ERROR!!! No se ha podido borrar el usuario con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}, usuario:{$_REQUEST['usuario']} Borrado correctamente";
                }
            }
            ?>
            <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                <?= $mensaje ?>
            </div>
            <table class="table-list table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Partidas Jugadas</th>
                        <th scope="col">Partidas Ganadas</th>
                        <th scope="col">Partidas Perdidas</th>
                        <th scope="col">Eliminar</th>
                        <th scope="col">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):
                        $id = $user->id;
                        ?>
                        <tr>
                            <th scope="row"><?= $user->id ?></th>
                            <td><?= $user->usuario ?></td>
                            <td><?= $user->partidas_jugadas ?></td>
                            <td><?= $user->partidas_ganadas ?></td>
                            <td><?= $user->partidas_perdidas ?></td>
                            <td>
                                <button class="btn-listar-borrar"><a href="index.php?tabla=user&accion=borrar&id=<?=$id?>">Borrar</a></button>
                            </td>
                            <td>
                                <button class="btn-listar-ver"><a href="index.php?tabla=user&accion=ver&id=<?=$id?>"> Ver</a></button>
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

</main>