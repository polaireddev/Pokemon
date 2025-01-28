<?php
require_once "controllers/JuegoController.php";

$controladorJuego = new JuegoController();
$idRivalSelect = $_REQUEST["idRival"];
$equipoUsuarioSesion = $controladorJuego->devolverEquipo($_SESSION["usuario"]->id);
$equipoRival = $controladorJuego->devolverEquipo($idRivalSelect);
$usuarioRival = $controladorJuego->devolverRival($idRivalSelect);
$visibilidad = "";
$mensaje = "";






?>



<main id="contenedor_main">

    <div id="contenedor_listar">

        <!--ESTE DIV CONTIENE LOS 2 CONTENEDORES DE EQUIPO -->
        <div id="contenedor2divs">


            <!--Inicio CONTENDOR EQUIPO USUARIO SESION--->

            <div id="contenido">
                <div>
                    <h1 class="titulo">Tu equipo</h1>

                </div>

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
                        <?php foreach ($equipoUsuarioSesion as $pokemon):
                            $id = $pokemon->id;
                        ?>
                            <tr>
                                <td><?= $pokemon->nombre ?></td>
                                <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>


                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>




            <!--CONTENDOR EQUIPO USUARIO SESION--->






            <!--CONTENDOR EQUIPO RIVAL--->


            <div id="contenido">
                <div>
                    <h1 class="titulo">EQUIPO de <?=$usuarioRival->usuario?></h1>

                </div>

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
                        <?php foreach ($equipoRival as $pokemon):
                            $id = $pokemon->id;
                        ?>
                            <tr>
                                <td><?= $pokemon->nombre ?></td>
                                <td><img src="<?= $pokemon->imagen ?>/<?= $pokemon->nombre ?>.gif" alt="Imagen de <?= $pokemon->nombre ?>"></td>


                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>


            <!--TEWRMINA AQUI CONTENEDOR EQUIPO RIVAL-->



        </div>
        <!---aqui temiran contedor 2 divs-->

        <div>
            <a href="index.php?tabla=juego&accion=seleccionRival">Volver al Menú</a>
        </div>
    </div>
</main>