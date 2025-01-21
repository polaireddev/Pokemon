<?php
require_once('config/db.php');

class PokemonModel{

    private $conexion;

    public function __construct(){
        $this->conexion = db::conexion();
    }

    public function devolverPokemonsLvl1Model(){
        
        try {

            $sentencia = $this->conexion->prepare("SELECT id FROM pokemon WHERE nivel = 1;");
            $sentencia->execute();

            $pokemons = $sentencia->fetchAll(PDO::FETCH_COLUMN);
            return $pokemons;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }

    }

    public function readAll(){
        try {

            $sentencia = $this->conexion->prepare("SELECT * FROM pokemon;");
            $sentencia->execute();

            $pokemons = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $pokemons;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }
    }    


    public function exists(string $campo, string $valor): bool
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM pokemon WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount() <= 0) ? false : true;
    }


    public function insert(array $pokemon): ?int 
    {
        $sql = "INSERT INTO pokemon(nombre, ataque, defensa, tipo, nivel, id_evolucion, imagen)  
        VALUES (:nombre, :ataque, :defensa, :tipo, :nivel, :id_evolucion, :imagen);";

        try {
            $sentencia = $this->conexion->prepare($sql);

            $arrayDatos = [
                ':nombre' => $pokemon["nombre"],
                ':ataque' => $pokemon["ataque"],
                ':defensa' => $pokemon["defensa"],
                ':tipo' => $pokemon["tipo"],
                ':nivel' => $pokemon["nivel"],
                ':id_evolucion' => null,
                ':imagen' => $pokemon["imagen"],
                
            ];
            $resultado = $sentencia->execute($arrayDatos);

        
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }
    }

}

?>