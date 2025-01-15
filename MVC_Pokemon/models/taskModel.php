<?php
require_once('config/db.php');

class TaskModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function search(string $campo = "id", string $metodo = "contiene", string $dato = ""): array
    {

        //FALTA SENTENCIA DE BBDD 
        $sentencia = $this->conexion->prepare("SELECT * FROM tasks WHERE $campo LIKE :dato");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($metodo) {
            case "contiene":
                $arrayDatos = [":dato" => "%$dato%"];
                break;
            case "empieza":
                $arrayDatos = [":dato" => "$dato%"];
                break;
            case "acaba":
                $arrayDatos = [":dato" => "%$dato"];
                break;
            case "igual":
                $arrayDatos = [":dato" => "$dato"];
                break;
            default:
                $arrayDatos = [":dato" => "%$dato%"];
                break;
        }
        
        $resultado = $sentencia->execute($arrayDatos);
        // if (!$resultado) return [];
        // $tasks = $sentencia->fetchAll(PDO::FETCH_OBJ);
        // return $tasks;
        // lo anterior se puede sustituir sólo por 
        return $resultado?$sentencia->fetchAll(PDO::FETCH_OBJ):[];
    }


    public function sarchByUser(stdClass $project, string $campo= "id", string $metodo="contiene", string $dato= ""):array{

        //sentencia sql
        $sql="";

        $sentencia= $this->conexion->prepare($sql);

        $arrayDatos[":user_id"]=$project->id;

        switch ($metodo) {
            case "contiene":
                $arrayDatos [":dato"] = "%$dato%";
                break;
            case "empieza":
                $arrayDatos [":dato"] = "$dato%";
                break;
            case "acaba":
                $arrayDatos [":dato"] = "%$dato";
                break;
            case "igual":
                $arrayDatos [":dato"] = "$dato";
                break;
            default:
            $arrayDatos [":dato"] = "%$dato%";
                break;
        }

        $resultado= $sentencia->execute($arrayDatos);
       // if(!$resultado) return[];
        //$projects= $sentencia->fetchAll(PDO::FETCH_OBJ);
        //return $projects;

        return $resultado?$sentencia->fetchAll(PDO::FETCH_OBJ):[];


    
    }


    //funcion donde en teoria le pasamos el id del proyecto, donde recogemos las tareas.

    function obtenerTareasProject($id){

        $sql = "select t.id, t.name, t.description, t.deadline, t.task_status, u.name as user_name, c.contact_name as client_name, t.user_id ";
        $sql.= "FROM tasks t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN clients c ON t.client_id = c.id ";
        $sql.= "WHERE t.project_id = :id";

        $sentencia = $this->conexion->prepare($sql);
        $arrayTareas= [':id'=>$id];

        $resultado = $sentencia->execute($arrayTareas);
        if (!$resultado) return [];
        $tasks = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $tasks;
        
        //$sql= $this->conexion->prepare("SELECT * FROM tasks WHERE project_id = :id");
        /*$arrayTareas= [':id'=>$id];
        $resultado= $sql->execute($arrayTareas);
        return $resultado?$sql->fetchAll(PDO::FETCH_OBJ):[];*/

    }

    function insert($nuevaTask){
        //Nos falta meter el ID del cliente porque no lo recogemos del cuestionario, sino del proyect controller
        try {
            $sql = "INSERT INTO tasks (name, description,deadline, task_status, user_id, client_id, project_id)  ";
            $sql.=" VALUES (:nameTask, :description,:deadline, :task_status, :user_id, :client_id, :project_id);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                 ":nameTask" => $nuevaTask["nameTask"],
                ":description" => $nuevaTask["description"],
                ":deadline" => $nuevaTask["deadline"],
                ":task_status" => $nuevaTask["status"],
                ":user_id" => $nuevaTask["user_id"],
                ":client_id" => $nuevaTask["client_id"],
                ":project_id"=> $nuevaTask["project_id"]
            ];
            
            $resultado = $sentencia->execute($arrayDatos);
            var_dump($resultado);
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return null;
        }
    }

    




    
    public function edit(int $idAntiguo, array $arrayTask): bool
    {
        try {
            $sql = "UPDATE tasks SET name = :name, description=:description, ";
            $sql .= "deadline = :deadline, task_status= :status, user_id=:user_id,client_id=:client_id  ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":name" => $arrayTask["nameTask"],
                ":description" => $arrayTask["description"],
                ":deadline" => $arrayTask["deadline"],
                ":status" => $arrayTask["status"],
                ":user_id" => $arrayTask["user_id"],
                ":client_id" => $arrayTask["client_id"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }



    public function readTask($id){
        $sql= "SELECT * FROM tasks WHERE id=:id";
        
        $sentencia = $this->conexion->prepare($sql);
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $task = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($task == false) ? null : $task;
    }

    public function delete($id){
        $sql = "DELETE FROM tasks WHERE id =:id";
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
    }

    
    
}

