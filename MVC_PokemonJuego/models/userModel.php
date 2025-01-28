<?php
require_once('config/db.php');

class UserModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }



//LOGIN
    public function login(string $usuario, string $password): ?stdClass
{
    
    $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE usuario = :usuario");
    $arrayDatos = [
        ":usuario" => $usuario,
    ];

    $resultado = $sentencia->execute($arrayDatos); 
    if (!$resultado) return null; 

    $user = $sentencia->fetch(PDO::FETCH_OBJ); 
    if (!$user) return null; 

    
    if (str_starts_with($user->password, '$2y$')) {
    
        if (!password_verify(trim($password), $user->password)) {
            return null; 
        }
    } else {
        
        if (trim($password) !== $user->password) {
            return null; 
        }
    }

    return $user;
}







    //obtener un usuario mediante Id

    public function read(int $id): ?stdClass 
    {


        try {

            $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE id=:id");
            $arrayDatos = [":id" => $id];
            $resultado = $sentencia->execute($arrayDatos);
    
            if (!$resultado)
                return null;
        
            $user = $sentencia->fetch(PDO::FETCH_OBJ); 
            
            return ($user == false) ? null : $user;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }
    }



//OBTENER TODOS LOS USUARIOS
    public function readAll(): array 
    {
        try {

            $sentencia = $this->conexion->prepare("SELECT * FROM users;");
            $sentencia->execute();

            $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $usuarios;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return [];
        }
    }


    


   

    
}
