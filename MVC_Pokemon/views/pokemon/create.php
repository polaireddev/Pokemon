<?php
require_once "assets/php/funciones.php";
require_once "controllers/pokemonController.php";

$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";

if (isset($_REQUEST["error"])) {
    $errores = ($_SESSION["errores"]) ?? [];
    $datos = ($_SESSION["datos"]) ?? [];
    $cadena = "Atención Se han producido Errores";
    $visibilidad = "visible";
}
// Verificar si se ha recibido el nivel a través de una solicitud AJAX
if ( isset($_POST['nivel'])) {
    $nivel = $_POST['nivel']; // Guardamos el nivel en una variable PHP
    $_SESSION['nivel'] = $nivel;

    
}



$pokemonControl = new pokemonController();
$pokemons = $pokemonControl->listar();
?>

<main id="contenedor_main">
    <div id="titulo_pokemon">
        <h1 class="titulo">Añadir Pokemon</h1>
    </div>
    <div id="contenido_form">
        <div><?= $cadena ?></div>
        <form id="formCreatePokemon" action="index.php?tabla=pokemon&accion=guardar&evento=crear" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre </label>
                <input type="text"  class="form-control" id="nombre" name="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? "" ?>" aria-describedby="nombre" placeholder="Introduce nombre">
                <?= isset($errores["nombre"]) ? '<div id="nombre-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
</div>

            <div class="form-group">
                <label for="ataque">Ataque</label>
                <input type="number"  class="form-control" id="ataque" name="ataque" value="<?= $_SESSION["datos"]["ataque"] ?? "" ?>" placeholder="Ataque">
                <?= isset($errores["ataque"]) ? '<div id="usuario-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "ataque") . '</div>' : ""; ?>
            </div>

            <div>
                <label for="defensa">Defensa </label>
                <input type="number"  class="form-control" id="defensa" name="defensa" value="<?= $_SESSION["datos"]["defensa"] ?? "" ?>" aria-describedby="defensa" placeholder="Defensa">
                <?= isset($errores["defensa"]) ? '<div id="defensa-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "defensa") . '</div>' : ""; ?>
            </div>

            <div>
                <label for="tipo">Tipo </label>
                <select id="tipo" name="tipo">
                    <option value="">---- Elije el Tipo ----</option>
                    <option value="Fuego">Fuego</option>
                    <option value="Agua">Agua</option>
                    <option value="Planta">Planta</option>
                    <option value="Tierra">Tierra</option>
                    <option value="Electrico">Eléctrico</option>
                </select>
                <?= isset($errores["tipo"]) ? '<div id="tipo-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "tipo") . '</div>' : ""; ?>
            </div>

            <div>
                <label for="nivel">Nivel </label>
                <select id="nivel" name="nivel" onchange="guardarNivel()">
                    <option value="">---- Elije el Nivel ----</option>
                    <option value="1">Nivel 1</option>
                    <option value="2">Nivel 2</option>
                    <option value="3">Nivel 3</option>
                </select>
                <?= isset($errores["nivel"]) ? '<div id="nivel-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nivel") . '</div>' : ""; ?>
            </div>

            

            <div>
                <label>Imagen por defecto:</label>
                <input type="file" name="file1" accept=".gif">
                <?= isset($errores["file1"]) ? '<div id="file1-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "file1") . '</div>' : ""; ?>
            </div>

            <div>
                <label>Imagen de derrota:</label>
                <input type="file" name="file2" accept=".gif">
                <?= isset($errores["file2"]) ? '<div id="file2-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "file2") . '</div>' : ""; ?>
            </div>

            <div>
                <label>Imagen de victoria:</label>
                <input type="file" name="file3" accept=".gif">
                <?= isset($errores["file3"]) ? '<div id="file3-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "file3") . '</div>' : ""; ?>
            </div>

            <div>
                <button type="submit">Guardar</button>
                <a href="index.php">Listar</a>
            </div>
        </form>

        <?php
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>



