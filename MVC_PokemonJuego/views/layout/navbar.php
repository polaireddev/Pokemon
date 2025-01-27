<?php
require_once "controllers/equipoController.php";

$equipoControl = new equipoController();
$pokemonsEquipo = $equipoControl->listar($_SESSION["usuario"]->id);
?>

<div id="contenedor_navbar">
  <nav>
    <ul>

      <li><a href="index.php?tabla=userPokemon&accion=listar">VerPokemons</a></li>
      <li><a href="index.php?tabla=equipoPokemon&accion=crear">Equipo</a></li>
      <?php
      $disable = "";
      $ruta = "index.php?tabla=user&accion=jugar";
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