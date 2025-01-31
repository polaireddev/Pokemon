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


    public function readAll($idUsuario){
        try {
            $sentencia = $this->conexion->prepare("SELECT pokemon_id FROM equipo_usuario WHERE usuario_id = :usuario_id ORDER BY numeroPokemon;");
            $arrayDatos = [":usuario_id" => $idUsuario];
            $sentencia->execute($arrayDatos);

            $pokemons = $sentencia->fetchAll(PDO::FETCH_COLUMN);
            return $pokemons;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }
    } 

    public function crear($idUsuario, $idPokemon1, $idPokemon2, $idPokemon3, $order1, $order2, $order3) {
        try {
            // Paso 1: Borrar los Pokémon existentes del equipo del usuario
            $sqlBorrar = "DELETE FROM equipo_usuario WHERE usuario_id = :idUsuario";
            $sentenciaBorrar = $this->conexion->prepare($sqlBorrar);
            // Ejecutamos la sentencia para borrar los Pokémon anteriores del equipo de este usuario
            $sentenciaBorrar->execute([":idUsuario" => $idUsuario]);
    
            // Paso 2: Insertar los nuevos Pokémon en una sola operación
            $sqlInsertar = "INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) 
                            VALUES (:idUsuario, :idPokemon, :numeroPokemon)";

            $sentenciaInsertar = $this->conexion->prepare($sqlInsertar);

                            for($i = 1; $i <= 3; $i ++){
                                if($i == 1){ $idPokemon = $idPokemon1; $numeroPokemon = $order1;}
                                elseif($i == 2){ $idPokemon = $idPokemon2; $numeroPokemon = $order2;}
                                else{ $idPokemon = $idPokemon3; $numeroPokemon = $order3;}
                                $sentenciaInsertar->execute([
                                    ":idUsuario" => $idUsuario,
                                    ":idPokemon" => $idPokemon,
                                    ":numeroPokemon" => $numeroPokemon
                                ]);
                            }
            
            
            // Ejecutamos la sentencia de inserción para agregar los tres nuevos Pokémon al equipo
            
    
            // Retornar verdadero si todo salió bien
            return true;
    
        } catch (Exception $e) {
            // Capturar cualquier error y retornar falso
            // Se captura cualquier excepción, se muestra el mensaje de error y se retorna false
            echo 'Excepción capturada en el modelo: ', $e->getMessage(), "<br>";
            return false;
        }
    }


    public function eliminarPokemonEquipoModel($idUsuario, $idPokemon){
        try {
            $sqlBorrar = "DELETE FROM equipo_usuario WHERE usuario_id = :idUsuario AND pokemon_id = :idPokemon";
            $sentenciaBorrar = $this->conexion->prepare($sqlBorrar);
            // Ejecutamos la sentencia para borrar los Pokémon anteriores del equipo de este usuario
            $sentenciaBorrar->execute([":idUsuario" => $idUsuario, ":idPokemon"=>$idPokemon]);
        
            //return $sentenciaBorrar;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }

    }
    
    
}