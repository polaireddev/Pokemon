<?php
require_once "assets/php/funciones.php";
$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
if (isset($_REQUEST["error"])) {
  $errores = ($_SESSION["errores"]) ?? [];
  $datos = ($_SESSION["datos"]) ?? [];
  $cadena = "Atención Se han producido Errores";
  $visibilidad = "visible";
}
?>
<main>
<div>
    <h1 class="h3">Añadir usuario</h1>
</div>
<div id="contenido">
    <div><?= $cadena ?></div>
    <form id="formCreateUser" action="index.php?tabla=user&accion=guardar&evento=crear" method="POST" >
    <div>
    <label for="usuario">Usuario </label>
        <input type="text" required class="form-control" id="usuario" name="usuario" value="<?= $_SESSION["datos"]["usuario"] ?? "" ?>" aria-describedby="usuario" placeholder="Introduce Usuario">
        <small id="usuario" class="form-text text-muted">Compartir tu usuario lo hace menos seguro.</small>
        <?= isset($errores["usuario"]) ? '<div  id="usuario-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "usuario"). '</div>' : ""; ?>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" required class="form-control" id="password" name="password" value="<?= $_SESSION["datos"]["password"] ?? "" ?>" placeholder="Password">
        <?= isset($errores["password"]) ? '<div  id="usuario-error" class="alert alert-danger" role="alert">' . DibujarErrores($errores, "password") . '</div>' : ""; ?>
    </div>
    <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
</div>
</main>