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



//INSERTAR
    public function insert(array $user): ?int 
    {
        $sql = "INSERT INTO users(usuario, password)  VALUES (:usuario, :password);";

        try {
            $sentencia = $this->conexion->prepare($sql);
            $hashedPassword = password_hash(trim($user["password"]), PASSWORD_DEFAULT);

            $arrayDatos = [
                ':usuario' => $user["usuario"],
                ':password' => $hashedPassword,
                
            ];
            $resultado = $sentencia->execute($arrayDatos);

        
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }
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

/*
    public function delete(int $id): bool //borrar usuario
    {
        $sql = "DELETE FROM users WHERE id =:id";
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
*/
/*
    public function edit(int $idAntiguo, array $arrayUsuario): bool
    {
        try {
            $sql = "UPDATE users SET name = :name, email=:email, ";
            $sql .= "usuario = :usuario, password= :password ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":usuario" => $arrayUsuario["usuario"],
                ":password" => $arrayUsuario["password"],
                ":name" => $arrayUsuario["name"],
                ":email" => $arrayUsuario["email"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }
*/
/*

    public function search(string $usuario, string $tipoBusqueda, string $busquedaPor): array
    {
        
        try {

            switch ($tipoBusqueda) {
                case "empiezaPor":
                    $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE $busquedaPor LIKE :usuario");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":usuario" => "$usuario%"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $users = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $users;

                case "acabaEn":
                    $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE $busquedaPor LIKE :usuario");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":usuario" => "%$usuario"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $users = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $users;

                case "contiene":
                    $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE $busquedaPor LIKE :usuario");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":usuario" => "%$usuario%"];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $users = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $users;

                case "igualA":
                    $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE $busquedaPor = :usuario");
                    //ojo el si ponemos % siempre en comillas dobles "
                    $arrayDatos = [":usuario" => $usuario];
                    $resultado = $sentencia->execute($arrayDatos);
                    if (!$resultado)
                        return [];
                    $users = $sentencia->fetchAll(PDO::FETCH_OBJ);
                    return $users;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
        }
        return [];
    }

*/


    


    public function exists(string $campo, string $valor): bool
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM users WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount() <= 0) ? false : true;
    }

    
}
