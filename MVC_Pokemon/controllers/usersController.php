<?php
require_once "assets/php/funciones.php";
require_once "models/userModel.php";

class UsersController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function crear(array $arrayUser): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        

        if (!validarPassword($arrayUser["password"])) {
            $error = true;
            $errores["password"][] = "La constraseña debe tener mínimo 6 caracteres, una minúscula, una mayúscula, un número y un símbolo (.,-_)";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["password", "usuario"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser); // Me devuele un array de nulo y aqui simplemente los recorre le añade un mensaje mediante un array asociativo
        if (count($nulos) > 0) { 
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["usuario"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayUser[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }

        //PATRON DE USUARIO (LETRAS Y NUMEROS)
        if (!validarUsuario($arrayUser["usuario"])) {
            $errores["usuario"][] = "Carácteres del usuario incorrectos";
            $error = true;
        }

        $id = null;
        if (!$error) {
            $id = $this->model->insert($arrayUser);
        }

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            header("location:index.php?tabla=user&accion=crear&error=true&id={$id}"); //CAMBIAR ESTO
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            header("location:index.php?tabla=user&accion=ver&id={$id}"); // CAMBIAR ESTO
            exit();
        }
    }





//VER USUARIO POR ID
    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

//LISTAR TODOS LOS USUARIOS
    public function listar($comprobarSiEsBorrable = false) //lo ponemos como false para cuando lo llamemmos en la vista lo ponemso en true y asi poder ejecutar el la condicion
    {
        $users = $this->model->readAll();
        return $users;
    }







    /*
SI NECESITMAOS ALGUNO DE ESTOS METODOS DESCOMENTAMOS AQUI Y EN EL MODELO

    */


    /* DELETE 
    public function borrar(int $id): void
    {
        $usuario = $this->ver($id);
        $borrado = $this->model->delete($id);

        $redireccion = "location:index.php?accion=listar&tabla=user&evento=borrar&id={$id}&nombre={$usuario->name}&usuario={$usuario->usuario}";

        if ($borrado == false)
            $redireccion .= "&error=true";
        header($redireccion);
        exit();
    }

*/

    


/* EDITAR
public function editar(string $id, array $arrayUser): void
{
    $error = false;
    $errores = [];
    if (isset($_SESSION["errores"])) {
        unset($_SESSION["errores"]);
        unset($_SESSION["datos"]);
    }

    

    //campos NO VACIOS
    $arrayNoNulos = ["password", "usuario"];
    $nulos = HayNulos($arrayNoNulos, $arrayUser);
    if (count($nulos) > 0) {
        $error = true;
        for ($i = 0; $i < count($nulos); $i++) {
            $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
        }
    }
    
    //CAMPOS UNICOS
    $arrayUnicos = [];
    if ($arrayUser["usuario"] != $arrayUser["usuarioOriginal"]) $arrayUnicos[] = "usuario";

    foreach ($arrayUnicos as $CampoUnico) {
        if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
            $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayUser[$CampoUnico]}  ya existe";
            $error = true;
        }
    }

    

    //todo correcto
    $editado = false;
    if (!$error) $editado = $this->model->edit($id, $arrayUser);

    if ($editado == false) {
        $_SESSION["errores"] = $errores;
        $_SESSION["datos"] = $arrayUser;
        $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}&error=true";


    } else {
        
        unset($_SESSION["errores"]);
        unset($_SESSION["datos"]);
        $id = $arrayUser["id"];
        $redireccion = "location:index.php?accion=editar&tabla=user&evento=modificar&id={$id}";
    }
    header($redireccion);
    exit ();
    
}

*/


/*BUSCAR
    public function buscar(string $campo = "usuario", string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $users = $this->model->search($campo, $metodo, $texto);

        if ($comprobarSiEsBorrable) {
            foreach ($users as $user) {
                $user->esBorrable = $this->esBorrable($user);
            }
        }
        return $users;
    }
*/





}
