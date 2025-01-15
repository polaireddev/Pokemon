<?php
require_once('config/db.php');

class ClientModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $client): ?int //devuelve entero o null
    {
        $sql = "INSERT INTO clients(idFiscal, contact_name, contact_email, contact_phone_number, company_name, company_address, company_phone_number)  
        VALUES (:idFiscal, :contact_name, :contact_email, :contact_phone_number, :company_name, :company_address, :company_phone_number);";

        try {
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ':idFiscal'=>$client['idFiscal'],
                ':contact_name'=>$client['contact_name'],
                ':contact_email'=>$client["contact_email"],
                ':contact_phone_number'=>$client["contact_phone_number"],
                ':company_name'=>$client["company_name"],
                ':company_address'=>$client["company_address"],
                ':company_phone_number'=>$client["company_phone_number"]
                
            ];
            $resultado = $sentencia->execute($arrayDatos);

            /*Pasar en el mismo orden de los ? execute devuelve un booleano. 
            True en caso de que todo vaya bien, falso en caso contrario.*/
            //Así podriamos evaluar
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }




    }

    public function read(int $id): ?stdClass
    {

        try {
            
            $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado)
            return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $client = $sentencia->fetch(PDO::FETCH_OBJ); //Objeto
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($client == false) ? null : $client;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        
        }
        
    }

    


    public function readAll():array{
        try {

            $sentencia = $this->conexion->prepare("SELECT * FROM clients;");
            $sentencia->execute();

            $clientes= $sentencia->fetchAll(PDO::FETCH_OBJ); //cambiado a read all;
            return $clientes;
            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }

    }

  
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM clients WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }


      //:idFiscal, :contact_name, :contact_email, :contact_phone_number, :company_name, :company_address, :company_phone_number
    public function edit(int $idAntiguo, array $arrayCliente): bool
    {
        try {
            $sql = "UPDATE clients SET   idFiscal=:idFiscal, contact_name = :contact_name, contact_email=:contact_email, ";
            $sql .= "contact_phone_number = :contact_phone_number, company_name= :company_name, company_address= :company_address,company_phone_number=:company_phone_number  ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":idFiscal"=>$arrayCliente["idFiscal"],
                ":contact_name" => $arrayCliente["contact_name"],
                ":contact_email" => $arrayCliente["contact_email"],
                ":contact_phone_number" => $arrayCliente["contact_phone_number"],
                ":company_name" => $arrayCliente["company_name"],
                ":company_address" => $arrayCliente["company_address"],
                ":company_phone_number" => $arrayCliente["company_phone_number"],
            
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }

    public function search(string $client, string $tipoBusqueda, string $busquedaPor): array
    {
        /*-----------------------------------------------------*/
        /*HE CAMBIADO TODO CON LOS SWITCH Y UN POCO EL CODIGO EN CUANTO A LAS CONSULTAS*/
        /*-----------------------------------------------------*/
        try {

            switch ($tipoBusqueda) {
                case "empiezaPor":
                    $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $busquedaPor LIKE :client");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":client" => "$client%"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $clients = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $clients;
                    
                case "acabaEn":
                    $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $busquedaPor LIKE :client");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":client" => "%$client"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $clientes = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $clientes;
                    
                case "contiene":
                    $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $busquedaPor LIKE :client");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":client" => "%$client%"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $clientes = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $clientes;
                    
                case "igualA":
                    $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $busquedaPor = :client"); //me cago en mi puta madre era una s
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":client" => $client];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $clients = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $clients;
                    
            }

        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
        }

        return [];
    }



    public function exists(string $campo, string $valor):bool{
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount()<=0)?false:true;
        }
     
    
}