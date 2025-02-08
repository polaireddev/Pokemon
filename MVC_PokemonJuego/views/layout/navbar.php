<?php
require_once "controllers/equipoController.php";
require_once "controllers/usersController.php";
require_once "controllers/pokemonController.php";

$equipoControl = new equipoController();
$pokemonsEquipo = $equipoControl->listar($_SESSION["usuario"]->id);
$usersControl = new UsersController();

if (isset($_SESSION["rival"])) {
  unset($_SESSION["rival"]);
  unset($_SESSION["jugador"]);
  unset($_SESSION["ganador"]);
}

$_SESSION["usuario"] = $usersControl->ver($_SESSION["usuario"]->id);

if(isset($_SESSION["pok"])){
  $pokemonControl = new pokemonController();
  $pokemonAsignado = $pokemonControl->ver($_SESSION["pok"]);
}

?>



<div id="contenedor_navbar">
  <div class="evolucionesDisponibles">
    <p><strong>Evoluciones Disponibles: <?= $_SESSION["usuario"]->evoluciones_disponibles ?></strong></p>
    <p><strong>Partidas Jugadas: <?= $_SESSION["usuario"]->partidas_jugadas ?></strong></p>
    <p><strong>Partidas Ganadas: <?= $_SESSION["usuario"]->partidas_ganadas ?></strong></p>
  </div>

  <?php if(isset($_SESSION["evolucion"])){ ?>
  <div class="recibidoEvolucion">
    <p>Has recibido una Evolución</p>
  </div>
  <?php } ?>

  <?php if(isset($_SESSION["pok"])){ ?>
  <div class="recibidoPokemon">
    <p>Has recibido un nuevo Pokemon: <?=$pokemonAsignado->nombre?></p>
    <img src="<?= $pokemonAsignado->imagen ?>/<?= $pokemonAsignado->nombre ?>.gif" alt="Imagen de <?= $pokemonAsignado->nombre ?>">
  </div>
  <?php } ?>

  <?php 
    unset($_SESSION["pok"]);
    unset($_SESSION["evolucion"]);
  ?>

  <nav>
    <ul>

      <li><a href="index.php?tabla=userPokemon&accion=listar">POKEMONS</a></li>
      <li><a href="index.php?tabla=equipoPokemon&accion=crear">EQUIPO</a></li>

      <?php
      $disable = "";
      $ruta = "index.php?tabla=juego&accion=seleccionRival";
      if (count($pokemonsEquipo) != 3) {
        $disable = "disabled";
        $ruta = "#";
      }
      ?>
      <li><a class="<?= $disable ?>" href="<?= $ruta ?>">LUCHAR</a></li>


      <?php
      $disable2 = "";
      $ruta2 = "index.php?tabla=userPokemon&accion=evolucionar";
      if ($_SESSION["usuario"]->evoluciones_disponibles < 1) {
        $disable2 = "disabled";
        $ruta2 = "#";
      } ?>
      <li><a class="<?= $disable2 ?>" href="<?= $ruta2 ?>">EVOLUCIONAR</a></li>



    </ul>



  </nav>
</div>


