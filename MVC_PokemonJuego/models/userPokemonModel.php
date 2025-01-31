<?php

    require_once('config/db.php');

    class userPokemonModel{

        private $conexion;

        public function __construct(){
            $this->conexion = db::conexion();
        }


        public function asignarPokemonsModel($user_id, $pokemon_id){

            $sql = "INSERT INTO pokemon_usuario(usuario_id, pokemon_id)  VALUES (:usuario_id, :pokemon_id);";

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


        public function mostrarPokemonsUsuarioModel($id){
            try {

                $sentencia = $this->conexion->prepare("SELECT * FROM pokemon_usuario WHERE usuario_id = :id;");
                $arrayDatos = [":id" => $id];
                $sentencia->execute($arrayDatos);
    
                $usuario_pokemons = $sentencia->fetchAll(PDO::FETCH_OBJ);
                return $usuario_pokemons;
            } catch (Exception $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "<br>";
                return [];
            }
        }


        public function readAll($idUsuario){
            try {
                $sentencia = $this->conexion->prepare("SELECT pokemon_id FROM pokemon_usuario WHERE usuario_id = :usuario_id;");
                $arrayDatos = [":usuario_id" => $idUsuario];
                $sentencia->execute($arrayDatos);
    
                $pokemons = $sentencia->fetchAll(PDO::FETCH_COLUMN);
                return $pokemons;
            } catch (Exception $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "<br>";
                return [];
            }
        } 


        public function modificarEvolucionModel($idPokemon, $idPokemonEvolucion, $idUsuario){

            $sentencia = $this->conexion->prepare("UPDATE pokemon_usuario SET pokemon_id = :idPokemonEvolucion WHERE usuario_id = :idUsuario AND pokemon_id = :idPokemon");
            $arrayDatos = [":idUsuario" => $idUsuario, ":idPokemon" => $idPokemon, ":idPokemonEvolucion" => $idPokemonEvolucion];
            $sentencia->execute($arrayDatos);

        }

    }



?>