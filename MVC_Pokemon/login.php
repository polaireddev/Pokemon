<?php
session_start();
$user = ($_POST["usuario"]) ?? "";
$password = ($_POST["password"]) ?? "";
$error = false;

if (isset($_POST["usuario"], $_POST["password"])) {
    require_once "models/userModel.php";
    $userModel = new userModel();
    $usuario = $userModel->login($user, $password);
    if ($usuario != null) {
        $_SESSION["usuario"] = $usuario;
        header("location:index.php");
        exit();
    }
    $error = true;
}

$msg = "";
$visibilidad = "none";
if ($error) {
    $msg = "Error, Usuario o Password Incorrectos";
    $visibilidad = "block";
}
if (isset($_GET["session"]) && ($_GET["session"] == "logout")) {
    $msg = "Fin de Sesion";
    $visibilidad = "block";
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/loginStyle.css">
    <title>Inicio de Sesión</title>
</head>

<body>

<div id="img_encabezado">
</div>
    
    
    <div id="form_contenedor">
   
        <form id="form_login" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

            <div id="imgTitulo">
                <img src="./assets/img/tituloPokemon.png" alt="pokemon" width="250px">
            </div>
            
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($user) ?>"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>"><br>
            <!-- Contenedor para checkbox y label -->
            <div class="checkbox-container">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Recuerdame</label>
            </div>
            <div id="error" style="display: <?= $visibilidad ?>;"><?= $msg ?></div>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <div id="pokemons">
        <img src="./assets/img/pokemons.png" alt="" width="300px">
    </div>
    </div>
    
</body>




</html>