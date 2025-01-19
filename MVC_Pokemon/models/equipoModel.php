<?php

require_once('config/db.php');

class equipoModel{

    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }



    //CAMBIAR
    function asignarPokemonsEquipoModel($user_id, $pokemon_id){

        $sql = "INSERT INTO equipo_usuario(usuario_id, pokemon_id)  VALUES (:usuario_id, :pokemon_id);";

    try {
        $sentencia = $this->conexion->prepare($sql);

        $arrayDatos = [
            ':usuario_id' => $user_id,
            ':pokemon_id' => $pokemon_id
        ];
        $resultado = $sentencia->execute($arrayDatos);

        return $resultado;

    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "<br>";
        return null;
    }

    }
}
