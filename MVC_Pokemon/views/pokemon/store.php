<?php
require_once "controllers/pokemonController.php";
//recoger datos
if (!isset ($_REQUEST["nombre"])){
   header('Location:index.php?tabla=pokemon&accion=crear' );
   exit();
}

$id= ($_REQUEST["id"])??"";//el id me servirá en editar
$arrayImagenes = [];
$_SESSION["errores"] = [];

$arrayPokemon=[    
            "id"=>$id,
            "nombre"=>$_REQUEST["nombre"],
            "ataque"=>$_REQUEST["ataque"],  
            "defensa"=>$_REQUEST["defensa"],
            "tipo"=>$_REQUEST["tipo"],
            "nivel"=>$_REQUEST["nivel"],
            "id_evolucion"=>isset($_REQUEST["id_evolucion"]) ?? null,
            "imagen"=>"assets/pokemons/".$_REQUEST["nombre"]    
        ];

//pagina invisible
$controlador= new PokemonController();

if ($_REQUEST["evento"]=="crear"){
    
    $maxFileSize = 3 * 1024 * 1024;

    $archivos = ["file1", "file2", "file3"];
    $errores = [];

    //Comprobamos el tamaño de las
    foreach ($archivos as $archivo) {
        if ($_FILES[$archivo]["size"] > $maxFileSize) {
            $errores[$archivo][] = "El archivo " . $_FILES[$archivo]["name"] . " excede el tamaño máximo de 3 MB.";
        }
    }

    if (count($errores) > 0) {
        // Si hay errores redirigimos a crear y le decimos cuales han sido
        $_SESSION["errores"] = $errores;
        header("location:index.php?tabla=pokemon&accion=crear&error=true&id={$id}");
        exit();
    }

    $id = $controlador->crear ($arrayPokemon, $arrayImagenes);

    if ($id != null) {
        // Crear la carpeta si no existe
        mkdir("assets/pokemons/" . $arrayPokemon["nombre"], 0777, true);
    
        // Guardamos la foto1 (Imagen por defecto)
        if ($_FILES["file1"]["name"] != "") {
            $temporal1 = $_FILES["file1"]["tmp_name"];
            $destino1 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . ".gif";
            if (!move_uploaded_file($temporal1, $destino1)) {
                echo "Ocurrió un error, no se ha podido subir el archivo $destino1<br>";
            }
        } else {
            // Si no se subió la imagen, copiamos la imagen predeterminada
            $destino1 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . ".gif";
            copy("assets/pokemons/default/defecto.gif", $destino1);
        }
    
        // Guardamos la foto2 (Imagen de derrota)
        if ($_FILES["file2"]["name"] != "") {
            $temporal2 = $_FILES["file2"]["tmp_name"];
            $destino2 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . "_R.gif";
            if (!move_uploaded_file($temporal2, $destino2)) {
                echo "Ocurrió un error, no se ha podido subir el archivo $destino2<br>";
            }
        } else {
            // Si no se subió la imagen, copiamos la imagen predeterminada para derrota
            $destino2 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . "_R.gif";
            copy("assets/pokemons/default/defecto_R.gif", $destino2);
        }
    
        // Guardamos la foto3 (Imagen de victoria)
        if ($_FILES["file3"]["name"] != "") {
            $temporal3 = $_FILES["file3"]["tmp_name"];
            $destino3 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . "_V.gif";
            if (!move_uploaded_file($temporal3, $destino3)) {
                echo "Ocurrió un error, no se ha podido subir el archivo $destino3<br>";
            }
        } else {
            // Si no se subió la imagen, copiamos la imagen predeterminada para victoria
            $destino3 = "assets/pokemons/" . $arrayPokemon["nombre"] . "/" . $arrayPokemon['nombre'] . "_V.gif";
            copy("assets/pokemons/default/defecto_V.gif", $destino3);
        }
    
        // Redirigimos a la vista del Pokémon
        header("location:index.php?tabla=pokemon&accion=ver&id={$id}");
        exit();
    }
}

if ($_REQUEST["evento"]=="modificarEvolucion"){
    $controlador->editarEvolucion ($_REQUEST["id"],$_REQUEST["idPokemonEvolucion"]);
    
}

if ($_REQUEST["evento"]=="modificarImagenes"){
    $pokemon = $controlador->ver($_REQUEST["id"]);
    
    //Guardamos la foto1
    $temporal1 = $_FILES["file1"]["tmp_name"];
    $destino = $pokemon->imagen."/".$pokemon->nombre.".gif";
    if (move_uploaded_file($temporal1, $destino)) {
        echo "Archivo subido con éxito";
    } else {
        echo "Ocurrió un error, no se ha podido subir el archivo";
    }

    //Guardamos la foto2
    $temporal2 = $_FILES["file2"]["tmp_name"];
    $destino = $pokemon->imagen."/".$pokemon->nombre."_R.gif";
    if (move_uploaded_file($temporal2, $destino)) {
        echo "Archivo subido con éxito";
    } else {
        echo "Ocurrió un error, no se ha podido subir el archivo";
    }

    //Guardamos la foto3
    $temporal3 = $_FILES["file3"]["tmp_name"];
    $destino = $pokemon->imagen."/".$pokemon->nombre."_V.gif";
    if (move_uploaded_file($temporal3, $destino)) {
        echo "Archivo subido con éxito";
    } else {
        echo "Ocurrió un error, no se ha podido subir el archivo";
    }

    header("location:index.php?tabla=pokemon&accion=ver&id={$id}");
    exit();
}