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


    public function read(int $id): ?stdClass 
    {
        try {

            $sentencia = $this->conexion->prepare("SELECT * FROM pokemon WHERE id=:id");
            $arrayDatos = [":id" => $id];
            $resultado = $sentencia->execute($arrayDatos);
    
            if (!$resultado)
                return null;
        
            $pokemon = $sentencia->fetch(PDO::FETCH_OBJ); 
            
            return ($pokemon == false) ? null : $pokemon;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }
    }


    public function listarEvolucionesPosiblesModel($tipo, $nivel){

        try {
            $nivelIncrementado= intval($nivel) +1;

            $sentencia = $this->conexion->prepare("SELECT * FROM pokemon WHERE tipo = :tipo AND nivel = :nivelIncrementado ;");
            $arrayDatos = [
                ":nivelIncrementado" => $nivelIncrementado,
                ":tipo" => $tipo];

            $sentencia->execute($arrayDatos);

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


    public function editEvolution($id, $id_evolucion){

        $sql = "UPDATE pokemon SET id_evolucion=:id_evolucion WHERE id = :id;";

        try {
            $sentencia = $this->conexion->prepare($sql);

            $arrayDatos = [
                ':id' => $id,
                ':id_evolucion' => $id_evolucion,            
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
        $sql= "SELECT * FROM pokemon WHERE $campo LIKE :dato ;";
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



 

public function delete(int $id): bool
{
    $sql = "DELETE FROM pokemon WHERE id =:id";
    try {
        $sentencia = $this->conexion->prepare($sql);
        //devuelve true si se borra correctamente
        //false si falla el borrado
        $resultado = $sentencia->execute([":id" => $id]);
        return ($sentencia->rowCount() <= 0) ? false : true;
    } catch (Exception $e) {
        echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
        return false;
    }




    


}}

?>