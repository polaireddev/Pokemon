<?php

require_once('config/db.php');

class equipoModel{

    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }



    //CAMBIAR
    function asignarPokemonsEquipoModel($user_id, $pokemon_id, $numeroPokemon){

        $sql = "INSERT INTO equipo_usuario(usuario_id, pokemon_id, numeroPokemon)  VALUES (:usuario_id, :pokemon_id, :numeroPokemon);";

    try {
        $sentencia = $this->conexion->prepare($sql);

        $arrayDatos = [
            ':usuario_id' => $user_id,
            ':pokemon_id' => $pokemon_id,
            ':numeroPokemon' => $numeroPokemon
        ];
        $resultado = $sentencia->execute($arrayDatos);

        return $resultado;

    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "<br>";
        return null;
    }

    }


    public function search(string $campo = "id", string $metodo = "contiene", string $dato = ""): array
    {
        $sql= "SELECT * FROM equipo_usuario WHERE $campo LIKE :dato ;";
        $sentencia = $this->conexion->prepare($sql);

        switch ($metodo) {
            case "contiene":
                $arrayDatos = [":dato" => "%$dato%"];
                break;
            case "empiezaPor":
                $arrayDatos = [":dato" => "$dato%"];
                break;
            case "acabaEn":
                $arrayDatos = [":dato" => "%$dato"];
                break;
            case "igualA":
                $arrayDatos = [":dato" => "$dato"];
                break;
            default:
                $arrayDatos = [":dato" => "%$dato%"];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $projects = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $projects;
    }
}
