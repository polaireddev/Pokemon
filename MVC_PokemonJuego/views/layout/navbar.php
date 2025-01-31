<?php
require_once "controllers/equipoController.php";
require_once "controllers/usersController.php";

$equipoControl = new equipoController();
$pokemonsEquipo = $equipoControl->listar($_SESSION["usuario"]->id);
$usersControl = new UsersController();

if (isset($_SESSION["rival"])) {
  unset($_SESSION["rival"]);
  unset($_SESSION["jugador"]);
  unset($_SESSION["ganador"]);
}

$_SESSION["usuario"] = $usersControl->ver($_SESSION["usuario"]->id);
?>



<div id="contenedor_navbar">
  <div class="evolucionesDisponibles">
    <p>Evoluciones Disponibles: <?= $_SESSION["usuario"]->evoluciones_disponibles ?></p>
  </div>
  <nav>
    <ul>

      <li><a href="index.php?tabla=userPokemon&accion=listar">VerPokemons</a></li>
      <li><a href="index.php?tabla=equipoPokemon&accion=crear">Equipo</a></li>
      <?php
      $disable = "";
      $ruta = "index.php?tabla=juego&accion=seleccionRival";
      if (count($pokemonsEquipo) != 3) {
        $disable = "disabled";
        $ruta = "#";
      }
      ?>
      <li><button class="<?= $disable ?>"><a href="<?= $ruta ?>">Jugar Partida</a></button></li>
      <li><a href="">Evolucionar</a></li>
    </ul>



  </nav>
</div>