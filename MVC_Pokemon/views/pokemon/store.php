<?php
require_once "controllers/pokemonController.php";
//recoger datos
if (!isset ($_REQUEST["nombre"])){
   header('Location:index.php?tabla=pokemon&accion=crear' );
   exit();
}

$id= ($_REQUEST["id"])??"";//el id me servirá en editar

$arrayPokemon=[    
            "id"=>$id,
            "nombre"=>$_REQUEST["nombre"],
            "ataque"=>$_REQUEST["ataque"],  
            "defensa"=>$_REQUEST["defensa"],
            "tipo"=>$_REQUEST["tipo"],
            "nivel"=>$_REQUEST["nivel"],
            "id_evolucion"=>$_REQUEST["id_evolucion"],
            "imagen"=>"assets/pokemons/".$_REQUEST["nombre"]    
        ];

//pagina invisible
$controlador= new PokemonController();

if ($_REQUEST["evento"]=="crear"){
    $id = $controlador->crear ($arrayPokemon, $arrayImagenes);

    if ($id != null){
        mkdir("assets/pokemons/".$arrayPokemon["nombre"], 0777,);

        //Guardamos la foto1
        $temporal1 = $_FILES["file1"]["tmp_name"];
        $destino = "assets/pokemons/".$arrayPokemon["nombre"]."/".$arrayPokemon['nombre'].".gif";
        if (move_uploaded_file($temporal1, $destino)) {
            echo "Archivo subido con éxito";
        } else {
            echo "Ocurrió un error, no se ha podido subir el archivo";
        }

        //Guardamos la foto2
        $temporal2 = $_FILES["file2"]["tmp_name"];
        $destino = "assets/pokemons/".$arrayPokemon["nombre"]."/".$arrayPokemon['nombre']."_R.gif";
        if (move_uploaded_file($temporal2, $destino)) {
            echo "Archivo subido con éxito";
        } else {
            echo "Ocurrió un error, no se ha podido subir el archivo";
        }

        //Guardamos la foto3
        $temporal3 = $_FILES["file3"]["tmp_name"];
        $destino = "assets/pokemons/".$arrayPokemon["nombre"]."/".$arrayPokemon['nombre']."_V.gif";
        if (move_uploaded_file($temporal3, $destino)) {
            echo "Archivo subido con éxito";
        } else {
            echo "Ocurrió un error, no se ha podido subir el archivo";
        }

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