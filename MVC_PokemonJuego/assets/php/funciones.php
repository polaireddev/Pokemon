<?php



function validarUsuario($usuario): bool
{
    $patron = "/^[A-Za-zÁÉÍÓÚáéíóúñÑa\d]+$/";

    if (preg_match($patron, $usuario)) {
        return true;
    }
    return false;
}

function validarPassword(string $password)
{
    $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.,\-_])[A-Za-z\d.,\-_]{6,}$/";
    if (preg_match($patron, $password)) {
        return true;
    }
    return false;
}



function validarPokemon($pokemon): bool
{
    $patron = "/^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/";

    if (preg_match($patron, $pokemon)) {
        return true;
    }
    return false;
}








function HayNulos(array $camposNoNulos, array $arrayDatos): array
{
    $nulos = [];
    foreach ($camposNoNulos as $index => $campo) {
        if (!isset($arrayDatos[$campo]) || empty($arrayDatos[$campo]) || $arrayDatos[$campo] == null) {
            $nulos[] = $campo;
        }
    }
    return $nulos;
}

function existeValor(array $array, string $campo, mixed $valor): bool
{
    return in_array($array[$campo], $valor);
}

//-----DIBUJAR ERRORES

function DibujarErrores($errores, $campo)
{
    $cadena = "";

    // Verificar si existen errores para el campo especificado
    if (isset($errores[$campo])) {
        // Obtener el último error en la lista de errores del campo
        $last = end($errores[$campo]);

        // Recorrer los errores del campo
        foreach ($errores[$campo] as $indice => $msgError) {
            // Si no es el último mensaje, añadir un salto de línea
            $salto = ($msgError != $last) ? "<br>" : "";

            // Concatenar el mensaje de error y el salto de línea
            $cadena .= "{$msgError}{$salto}";
        }
    }

    return $cadena;
}



//FUNCIONES DE COMBATE

function calcularGanador($equipo, $equipoRival){
    $mensajes=[];

    foreach($equipo as $index => $pokemon){
        if($pokemon->poder > $equipoRival[$index]->poder){
            $mensajes["ronda".($index+1)]="pokemonJugador";
        }
        else {
            $mensajes["ronda".($index+1)]="pokemonRival";
        }
    }
    return $mensajes;
}


function calcularPuntuacion($pokemon, $tipoPokemon2): int
{
    $puntuacion = 0;
    $numeroRandom = rand(1, 50);



    switch ($pokemon->tipo) {
        case "Agua":
            if ($tipoPokemon2 == "Fuego") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 10 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Tierra") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Electrico") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Planta") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 10 + $numeroRandom;
            } else {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + $numeroRandom;
            }
            break;

        case "Fuego":
            if ($tipoPokemon2 == "Planta") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 10 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Electrico") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Tierra") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Agua") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 10 + $numeroRandom;
            } else {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + $numeroRandom;
            }

            break;

        case "Planta":
            if ($tipoPokemon2 == "Agua") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 10 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Tierra") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Electrico") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Fuego") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 10 + $numeroRandom;
            } else {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + $numeroRandom;
            }

            break;

        case "Electrico":
            if ($tipoPokemon2 == "Agua") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 10 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Planta") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Fuego") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Tierra") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 10 + $numeroRandom;
            } else {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + $numeroRandom;
            }

            break;

        case "Tierra":
            if ($tipoPokemon2 == "Electrico") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 10 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Fuego") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Agua") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 5 + $numeroRandom;
            } elseif ($tipoPokemon2 == "Planta") {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) - 10 + $numeroRandom;
            } else {
                $puntuacion = intval($pokemon->ataque) + intval($pokemon->defensa) + $numeroRandom;
            }

            break;
    }


    return $puntuacion;
};
