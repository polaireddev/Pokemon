<?php
require_once "models/taskModel.php";
require_once "assets/php/funciones.php";


class TasksController
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskModel();
    }
 
    public function buscar(string $campo = "id", string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $tasks = $this->model->search($campo, $metodo, $texto);
    
        if ($comprobarSiEsBorrable) {
            foreach ($tasks as $task) {
                $task->esBorrable = $this->esBorrable($task);
            }
        }
        return $tasks;
    }
    
    private function esBorrable(stdClass $task): bool
    {
         $taskController = new ProjectsController();
         $borrable = true;
        // si ese usuario está en algún proyecto, No se puede borrar.
         if (count($taskController->buscar("user_id", "igual", $task->id)) > 0)
             $borrable = false;
    
        return $borrable;
    }


// llamamos al modelo, es decir la consulta de la bbdd
    function tareasProject($id){

        $task = $this->model->obtenerTareasProject($id);
        return $task;
    }


    function crear($arrayTask){
        
        $error = false;
        $errores = [];

        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nameTask", "status", "user_id"];
        $nulos = HayNulos($arrayNoNulos, $arrayTask);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS NINGUNO

              // **Validación de fecha**
    if (!empty($arrayTask["deadline"])) {
        $fechaActual = date('Y-m-d');
        if ($arrayTask["deadline"] < $fechaActual) {
            $error = true;
            $errores["deadline"][] = "La fecha límite no puede ser anterior a la fecha actual ({$fechaActual}).";
        }
    }

        $id = null;
        if (!$error) $id = $this->model->insert($arrayTask);

          if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayTask;
            $idProject= $arrayTask["project_id"];
            header("location:index.php?accion=crear&tabla=task&error=true&id={$id}&project_id={$idProject} ");

            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            $idProject= $arrayTask["project_id"];
            $idTarea= $id;
            $nombreTarea= $arrayTask["nameTask"];
             header("location:index.php?accion=ver&tabla=project&id={$idProject}&idtarea={$idTarea}&nameTarea={$nombreTarea}"); //por aqui despus pasar tamien el id de la tarea para 
             
            exit();
        }
    }

    


    public function ver(int $id): ?stdClass
    {
        return $this->model->readTask($id);
    }

    function borrar($id){
        $taskBorrar = $this->ver($id);
        $borrado = $this->model->delete($id);
        //CAMBIAR LA DIRECCION CUANDO SE TERMINEN DE HACER LAS FUNCIONES
        $redireccion = "location:index.php?accion=ver&tabla=project&evento=borrar&id={$taskBorrar->project_id}&name={$taskBorrar->name}";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }
    








    //ultimo 

    public function editar(string $id, array $arrayTask): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nameTask", "status", "user_id"];
        $nulos = HayNulos($arrayNoNulos, $arrayTask);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
            }
        }



         // **Validación de fecha**
    if (!empty($arrayTask["deadline"])) {
        $fechaActual = date('Y-m-d');
        if ($arrayTask["deadline"] < $fechaActual) {
            $error = true;
            $errores["deadline"][] = "La fecha límite no puede ser anterior a la fecha actual ({$fechaActual}).";
        }
    }
        
        //CAMPOS UNICOS NINGUNO
 
        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayTask); //VMOS MODELO

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayTask;
            $redireccion = "location:index.php?accion=editar&tabla=task&evento=modificar&id={$id}&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayTask["id"];
            $taskNameNuevo= $arrayTask["name"];
            $idProyecto = $arrayTask["project_id"];
            $redireccion = "location:index.php?accion=ver&tabla=project&id={$idProyecto}&project={$taskNameNuevo}"; 
        }
        header($redireccion);
        exit ();
        //vuelvo a la pagina donde estaba
    }

}
