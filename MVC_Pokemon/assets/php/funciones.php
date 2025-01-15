<?php



function validarUsuario($usuario):bool{
    $patron ="/^[A-Za-zÁÉÍÓÚáéíóúñÑa\d]+$/";

    if(preg_match($patron, $usuario)){
        return true;
    }
    return false;



}

function validarPassword(string $password){
    $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.,\-_])[A-Za-z\d.,\-_]{6,}$/";
    if(preg_match($patron, $password)){
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
        return in_array ($array[$campo],$valor);

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

 

