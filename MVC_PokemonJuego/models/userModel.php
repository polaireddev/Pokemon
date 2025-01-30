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

public function sumarPartidas($idJugador){
    $sentencia = $this->conexion->prepare("UPDATE users SET partidas_jugadas = partidas_jugadas + 1 WHERE id = :idJugador");
    $arrayDatos = [":idJugador" => $idJugador];
    $sentencia->execute($arrayDatos);
}

public function sumarPartidasGanadas($idJugador){
    $sentencia = $this->conexion->prepare("UPDATE users SET partidas_ganadas = partidas_ganadas + 1 WHERE id = :idJugador");
    $arrayDatos = [":idJugador" => $idJugador];
    $sentencia->execute($arrayDatos);
}

public function sumarPartidasPerdidas($idJugador){
    $sentencia = $this->conexion->prepare("UPDATE users SET partidas_perdidas = partidas_perdidas + 1 WHERE id = :idJugador");
    $arrayDatos = [":idJugador" => $idJugador];
    $sentencia->execute($arrayDatos);
}
    
public function verPartidasJugadas($idJugador): ?int{

    try {
        $sentencia = $this->conexion->prepare("SELECT partidas_jugadas FROM users WHERE id=:id");
        $arrayDatos = [":id" => $idJugador];
        $sentencia->execute($arrayDatos);

        $result = $sentencia->fetchColumn();
        return ($result!==false)?(int)$result:null;

    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "<br>";
        return null;
    }

}
public function verPartidasGanadas($idJugador): ?int {
    try {
        $sentencia = $this->conexion->prepare("SELECT partidas_ganadas FROM users WHERE id = :id");
        $sentencia->execute([":id" => $idJugador]);

        // Obtener el valor directamente con fetchColumn()
        $resultado = $sentencia->fetchColumn();

        // Asegurar que se devuelve un entero o null si no se encuentra el usuario
        return ($resultado !== false) ? (int) $resultado : null;

    } catch (Exception $e) {
        error_log('Excepción capturada: ' . $e->getMessage());
        return null;
    }
}

public function insertarEvolucion($idJugador){
    $sentencia = $this->conexion->prepare("UPDATE users SET evoluciones_disponibles = evoluciones_disponibles + 1 WHERE id = :idJugador");
    $arrayDatos = [":idJugador" => $idJugador];
    $sentencia->execute($arrayDatos);
}





   

    
}
