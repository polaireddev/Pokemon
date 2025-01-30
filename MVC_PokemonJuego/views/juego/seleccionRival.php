<?php
require_once "controllers/juegoController.php";
require_once "assets/php/funciones.php";




$controlador = new equipoController();

$pokemons = $controlador->listarTodos($_SESSION["usuario"]->id); // Obtenemos todos los pokemons de un usuario específico
$visibilidad = "hidden";
$equipoPokemon = $controlador->listar($_SESSION["usuario"]->id);




//usuarios

$controladorJuego = new JuegoController();
$idUsuarioSesion = $_SESSION["usuario"]->id;
$rivales=$controladorJuego->devolverRivales();

//Rival Aleatorio
$posicionAleatoria = rand(1, count($rivales)) -1;
while ($rivales[$posicionAleatoria]->id == $_SESSION["usuario"]->id){
    $posicionAleatoria = rand(1, count($rivales)) -1;
}
$idRival = $rivales[$posicionAleatoria]->id;



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

                <div id="rivalAleatorio">

                    <button><a href="index.php?tabla=juego&accion=luchar&idRival=<?=$idRival?>&nombreRival=<?=$rivales[$posicionAleatoria]->usuario?>">Rival Aleatorio</a></button>
                    
                </div>

            </div>

            <!--DIV ELIGE RIVAL SELECT-->

            <div id="listaSelect">
                <div>
                    <h1 class="titulo">Elige tu rival</h1>
                </div>

                <div id="formCreate">
                    <form action="index.php?tabla=juego&accion=luchar" method="POST">
                        <div>
                            <label for="idRival">ELIGE EL USUARIO A COMBATIR A MUERTE</label>
                            <select id="idRival" name="idRival">
                             
                                <?php
                                foreach ($rivales as $rival):
                                    if($rival->id != $_SESSION["usuario"]->id){
                                        echo "<option value='{$rival->id}'> {$rival->usuario}  </option>";
                                    }
                                endforeach;
                                ?>
                                
                            </select>
                            
                        </div>

                        
                        <input type="submit" value="Enviar">
                    </form>
                </div>

            </div>





            <!--DIV DE LISTA SELECT-->




        </div>
        <!--ESTE DIV CONTIENE LISTA EQUIPO Y LISTA SELECT -->






























        <a href="index.php">Volver al Menú</a>

    </main>

</div>