<?php
require_once "controllers/equipoController.php";


$controlador = new equipoController();
$idUsuarioSesion = $_SESSION["usuario"]->id;
$pokemons = $controlador->listarTodos($_SESSION["usuario"]->id); // Obtenemos todos los pokemons de un usuario específico
$visibilidad = "hidden";
$equipoPokemon = $controlador->listar($_SESSION["usuario"]->id) ;
?>
<div id="contenedor_main">

<?php if (isset($_SESSION["errores"]["repetidos"]) && !empty($_SESSION["errores"]["repetidos"])) : ?>
    <div class="alert alert-danger">
        <?php
        foreach ($_SESSION["errores"]["repetidos"] as $mensaje) :
            ?>
            <p><?= $mensaje ?></p> <!-- Mostrar el mensaje de error -->
        <?php
        endforeach;
        ?>
    </div>
<?php endif; ?>







    <main id="contenedor_listar">

        <!--ESTE DIV CONTIENE LISTA EQUIPO Y LISTA SELECT -->
        <div id="contenedor2divs">
            <!-- DIV LISTA EQUIPO -->


            <div id="listaEquipo">
                <div id="contenido_listarEquipo">
                    <h1 class="titulo">Tu equipo</h1>

                </div>

                <div id="contenido">
                    <?php
                    if (count($equipoPokemon) <= 0):
                        echo "No hay Datos a Mostrar";
                    else:
                        // Comprobamos si se debe mostrar el mensaje de éxito o error
                        if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") {
                            $visibilidad = "visible";
                            $clase = "alert alert-success";
                            // Mejorar y poner el nombre/usuario
                            $mensaje = "El pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]} fue borrado correctamente";

                            if (isset($_REQUEST["error"])) {
                                $clase = "alert alert-danger";
                                $mensaje = "ERROR!!! No se ha podido borrar el pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}";
                            }
                        }
                    ?>
                        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
                            <?= $mensaje ?>
                        </div>

                        <table class="table-list table-light table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Pokemon</th>
                                    <th scope="col">Imagen</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equipoPokemon as $pokemon):
                                    $id = $pokemon->id;
                                ?>
                                    <tr>
                                        <td><?= $pokemon->nombre ?></td>
                                        <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

            </div>


            <!--DIV LISTA EQUIPO -->







            <!--DIV LISTA SELECT-->

            <div id="listaSelect">
                <div>
                    <h1 class="titulo">CREA EQUIPO</h1>
                </div>

                <div id="formCreate">
                    <form action="index.php?tabla=equipoPokemon&accion=guardar&evento=crear&idUsuarioSesion=<?= $idUsuarioSesion ?>" method="POST">
                        <div>
                            <label for="idPokemon1">Pokemon 1</label>
                            <select id="idPokemon1" name="idPokemon1">
                                <option value="" disabled selected>---- Elije el Pokemon 1 de tu Equipo ----</option>
                                <?php
                                foreach ($pokemons as $pokemon):

                                    /*$disabled = in_array($pokemon->id, array_column($equipoPokemon, 'id')) ? 'disabled' : '';*/

                                    $selected= (($equipoPokemon[0])&&$pokemon->id ==$equipoPokemon[0]->id)? 'selected': "";
                                    echo "<option value='{$pokemon->id}' {$selected} {$disabled}> id: {$pokemon->id} - {$pokemon->nombre} </option>";
                                endforeach;
                                ?>
                            </select>
                            <input type="hidden" name="pokemon1" value="pokemon1">
                        </div>

                        <div>
                            <label for="idPokemon2">Pokemon 2</label>
                            <select id="idPokemon2" name="idPokemon2">
                                <option value="" disabled selected>---- Elije el Pokemon 2 de tu Equipo ----</option>
                                <?php
                                foreach ($pokemons as $pokemon):

                                   

                                    /*select por defautl */
                                    $selected= ($pokemon->id==$equipoPokemon[1]->id)? 'selected': "";
                                    echo "<option value='{$pokemon->id}' {$selected} {$disabled}> id: {$pokemon->id} - {$pokemon->nombre}</option>";
                                endforeach;
                                ?>
                            </select>
                            <input type="hidden" name="pokemon2" value="pokemon2">
                        </div>

                        <div>
                            <label for="idPokemon3">Pokemon 3</label>
                            <select id="idPokemon3" name="idPokemon3">
                                <option value="" disabled selected>---- Elije el Pokemon 3 de tu Equipo ----</option>
                                <?php
                                foreach ($pokemons as $pokemon):
                                    


                                    $selected= ($pokemon->id ==$equipoPokemon[2]->id)? 'selected': "";
                                    echo "<option value='{$pokemon->id}' {$selected} {$disabled}> id: {$pokemon->id} - {$pokemon->nombre} </option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="pokemon3" value="pokemon3">
                        <input type="submit" value="Enviar">
                    </form>
                </div>

            </div>





            <!--DIV DE LISTA SELECT-->




        </div>
        <!--ESTE DIV CONTIENE LISTA EQUIPO Y LISTA SELECT -->














        <!--DIV Lista de todos los pokemons para ver estadisticas--->

        <div id="pokemonsLista">



            <div>
                <h1 class="titulo">Tus Pokemons</h1>
            </div>

            <div id="contenido">
                <?php
                if (count($pokemons) <= 0):
                    echo "No hay Datos a Mostrar";
                else:
                    // Comprobamos si se debe mostrar el mensaje de éxito o error
                    if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") {
                        $visibilidad = "visible";
                        $clase = "alert alert-success";
                        // Mejorar y poner el nombre/usuario
                        $mensaje = "El pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]} fue borrado correctamente";

                        if (isset($_REQUEST["error"])) {
                            $clase = "alert alert-danger";
                            $mensaje = "ERROR!!! No se ha podido borrar el pokemon con id: {$_REQUEST['id']}, con nombre: {$_REQUEST["nombre"]}";
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
                                <th scope="col">Evolución</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pokemons as $pokemon):
                                $id = $pokemon->id;
                            ?>
                                <tr>
                                    <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>
                                    <th scope="row"><?= $pokemon->id ?></th>
                                    <td><?= $pokemon->nombre ?></td>
                                    <td><?= $pokemon->ataque ?></td>
                                    <td><?= $pokemon->defensa ?></td>
                                    <td><?= $pokemon->tipo ?></td>
                                    <td><?= $pokemon->nivel ?></td>
                                    <td><?= $pokemon->id_evolucion ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </div>


        <!--Lista de todos los pokemons para ver estadisticas--->















    <div id="div_volver_menu_equipo">
        <a href="index.php">Volver al Menú</a>
    </div>
        

    </main>
    <?php
unset($_SESSION["errores"]);
    ?>

</div>