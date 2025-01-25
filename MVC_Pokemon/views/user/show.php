<?php
require_once "controllers/usersController.php";
if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}
$id = $_REQUEST['id'];
$controlador = new usersController();
$user = $controlador->ver($id);
?>
<main>
    <div>
        <h1 class="h3">Ver Usuario</h1>
    </div>
    <div id="contenido">
        <div>
            <div>
                <h5>ID: <?= $user->id ?></h5>
                <p>
                    Nick: <?= $user->usuario ?> <br>
                    Partidas Ganadas: <?= $user->partidas_ganadas ?><br>
                    Partidas Perdidas: <?= $user->partidas_perdidas ?><br>
                    Partidas Jugadas: <?= $user->partidas_jugadas ?><br>
                    Evoluciones Disponibles: <?= $user->evoluciones_disponibles ?><br>
                    Administrador: <?= $user->administrador ?><br>
                </p>
                <a href="index.php?tabla=user&accion=listar">Volver a Inicio</a>
            </div>
        </div>
</main>