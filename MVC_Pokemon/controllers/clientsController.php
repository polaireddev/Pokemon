<?php
require_once "assets/php/funciones.php";
require_once "models/clientModel.php";
require_once "controllers/projectsController.php";//este añadido


class ClientsController
{
    private $model;

    public function __construct()
    {
        $this->model = new ClientModel();
    }

    public function crear(array $arrayClient): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO
        if (!is_valid_email($arrayClient["contact_email"])) {
            $error = true;
            $errores["contact_email"][] = "El email tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["contact_email", "idFiscal", "contact_name", "company_name"];
        $nulos = HayNulos($arrayNoNulos, $arrayClient);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["contact_email", "idFiscal"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayClient[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayClient[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }

        /*PATRONES*/
        if (!validarNombre($arrayClient["contact_name"])) {
            $errores["contact_name"][] = "Carácteres del cliente incorrectos";
            $error = true;
        }

        if (!validarTelefono($arrayClient["contact_phone_number"])) {

            $errores["contact_phone_number"][] = "Formato  incorrecto del tlf del cliente";
            $error = true;
        }

        if (!validarTelefono($arrayClient["company_phone_number"])) {

            $errores["company_phone_number"][] = "Formato  incorrecto del tlf de la compañía";
            $error = true;
        }

        if (!is_valid_dni($arrayClient["idFiscal"]) && !validarCIF($arrayClient["idFiscal"])) {
            $errores["idFiscal"][] = "idFiscal no válido";
            $error = true;
        }



        $id = null;
        if (!$error) $id = $this->model->insert($arrayClient);

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayClient;
            header("location:index.php?accion=crear&tabla=client&error=true&id={$id}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            header("location:index.php?accion=ver&tabla=client&id=" . $id);
            exit();
        }
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }



    public function borrar(int $id): void
    {
        $cliente = $this->ver($id);
        $borrado = $this->model->delete($id);

        /**
         *+++++++++++++++++++++++COMPORBAR EL REDIRECCIONAMIENTO POR LOS EVENTOS QUE SE PASAN AL REQUEST+++++++++++++++++++++++++++++++
         */
        $redireccion = "location:index.php?accion=listar&tabla=client&evento=borrar&id={$id}&nombre={$cliente->contact_name}";

        if ($borrado == false)
            $redireccion .= "&error=true";
        header($redireccion);
        exit();
    }


    /*
    public function editar1(int $id, array $arrayClient): void
    {
        $editadoCorrectamente = $this->model->edit($id, $arrayClient);
        //lo separo para que se lea mejor en el word
        $redireccion = "location:index.php?tabla=client&accion=editar";
        $redireccion .= "&evento=modificar&id={$id}";
        $redireccion .= ($editadoCorrectamente == false) ? "&error=true" : "";
        //vuelvo a la pagina donde estaba
        header($redireccion);
        exit();
    }
*/
    
//--------------
public function editar(string $id, array $arrayClient): void
{
    $error = false;
    $errores = [];
    if (isset($_SESSION["errores"])) {
        unset($_SESSION["errores"]);
        unset($_SESSION["datos"]);
    }

    // ERRORES DE TIPO
    if (!is_valid_email($arrayClient["contact_email"])) {
        $error = true;
        $errores["contact_email"][] = "El email tiene un formato incorrecto";
    }

    //campos NO VACIOS
    $arrayNoNulos = ["contact_email", "idFiscal", "contact_name", "company_name"];
    $nulos = HayNulos($arrayNoNulos, $arrayClient);
    if (count($nulos) > 0) {
        $error = true;
        for ($i = 0; $i < count($nulos); $i++) {
            $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
        }
    }
    
    //CAMPOS UNICOS
    $arrayUnicos = [];
    if ($arrayClient["contact_email"] != $arrayClient["contact_emailOriginal"]) $arrayUnicos[] = "contact_email";
    if ($arrayClient["idFiscal"] != $arrayClient["idFiscalOriginal"]) $arrayUnicos[] = "idFiscal";

    foreach ($arrayUnicos as $CampoUnico) {
        if ($this->model->exists($CampoUnico, $arrayClient[$CampoUnico])) {
            $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayClient[$CampoUnico]}  ya existe";
            $error = true;
        }
    }


    
    /*PATRONES*/
    if (!validarNombre($arrayClient["contact_name"])) {
        $errores["contact_name"][] = "Carácteres del cliente incorrectos";
        $error = true;
    }

    if (!validarTelefono($arrayClient["contact_phone_number"])) {

        $errores["contact_phone_number"][] = "Formato  incorrecto del tlf del cliente";
        $error = true;
    }

    if (!validarTelefono($arrayClient["company_phone_number"])) {

        $errores["company_phone_number"][] = "Formato  incorrecto del tlf de la compañía";
        $error = true;
    }

    if (!is_valid_dni($arrayClient["idFiscal"]) && !validarCIF($arrayClient["idFiscal"])) {
        $errores["idFiscal"][] = "idFiscal no válido";
        $error = true;
    }

    //todo correcto
    $editado = false;
    if (!$error) $editado = $this->model->edit($id, $arrayClient);

    if ($editado == false) {
        $_SESSION["errores"] = $errores;
        $_SESSION["datos"] = $arrayClient;
        $redireccion = "location:index.php?accion=editar&tabla=client&evento=modificar&id={$id}&error=true";




    } else {
        //vuelvo a limpiar por si acaso
        unset($_SESSION["errores"]);
        unset($_SESSION["datos"]);
        //este es el nuevo numpieza
        $id = $arrayClient["id"];
        $redireccion = "location:index.php?accion=editar&tabla=client&evento=modificar&id={$id}";
    }
    header($redireccion);
    exit ();
    //vuelvo a la pagina donde estaba
}




//------------






private function esBorrable(stdClass $client) {
        $projectController = new ProjectsController();
        $borrable = true;
        if (count($projectController->buscar("client_id", "igual", $client->id)) > 0)
            $borrable = false;
        return $borrable;
    }


    public function buscar(string $campo="id", string $tipoBusqueda="contiene", string $busquedaPor="" , $comprobarSiEsBorrable = false): array
    {
        $clients= $this->model->search($campo, $tipoBusqueda, $busquedaPor);
        if($comprobarSiEsBorrable){
            foreach ($clients as $client) {
                $client->esBorrable= $this->esBorrable($client);
            
            }
        }
        return $clients;
    }

    public function listar($comprobarSiEsBorrable = false)
    {
        $clients = $this->model->readAll();
        if ($comprobarSiEsBorrable) {
            foreach ($clients as $client) {
                $client->esBorrable = $this->esBorrable($client);
            }
        }
        return $clients;
    }

    


    




    

    
}
