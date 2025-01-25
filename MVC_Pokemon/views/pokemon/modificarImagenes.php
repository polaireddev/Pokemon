<?php
require_once "assets/php/funciones.php";
require_once "controllers/pokemonController.php";

$pokemonControlador = new pokemonController();
$pokemon = $pokemonControlador->ver($_REQUEST["id"]);


?>


<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Imagenes de: <?= $_REQUEST["nombre"] ?></h1>

    <div>
        <p>Imagen Actual por Defecto</p>
        <img src=<?= $pokemon->imagen . "/" . $pokemon->nombre . ".gif" ?> alt="">
    </div>

    <div>
        <p>Imagen Actual de Derrota</p>
        <img src=<?= $pokemon->imagen . "/" . $pokemon->nombre . "_R.gif" ?> alt="">
    </div>

    <div>
        <p>Imagen Actual de Victoria</p>
        <img src=<?= $pokemon->imagen . "/" . $pokemon->nombre . "_V.gif" ?> alt="">
    </div>

    <form
        action="index.php?tabla=pokemon&accion=guardar&evento=modificarImagenes&nombre=<?=$_REQUEST["nombre"]?>&id=<?= $pokemon->id?>"
        method="post" enctype="multipart/form-data">

        <div>
            <label for="idPokemonEvolucion">Pokemon </label>
        </div>

        <div>
            <label>Imagen por defecto:</label>
            <input type="file" name="file1" accept=".gif">
        </div>

        <div>
            <label>Imagen de derrota:</label>
            <input type="file" name="file2" accept=".gif">
        </div>

        <div>
            <label>Imagen de victoria:</label>
            <input type="file" name="file3" accept=".gif">
        </div>

        <div>
            <input type="submit" value="Guardar">
            <a href="index.php">Listar</a>
        </div>

    </form>


</body>

</html>