<?php
require_once "controllers/pokemonController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new pokemonController();
$pokemon = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $pokemons = $controlador->listar();
            break;
            


        case "filtrar":
            $texto = ($_REQUEST["busqueda"]) ?? "nombre";
            $metodo = ($_REQUEST["tipoBusqueda"]) ?? "contiene";
            $campo = ($_REQUEST["busquedaPor"]) ?? "";
            //es borrable Parametro con nombre
            $pokemons = $controlador->buscar($campo, $metodo, $texto,  comprobarSiEsBorrable:true); 
            break;


    
    }
} ?>



<main id="contenedor_listar">
    <div >
        <h1 class="titulo">Buscar Pokemon</h1>
    </div>
    <div id="contenido">
        <?php if($mensaje != ""){ ?>
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <?php }  ?>
        <div>
            <form action="index.php?tabla=pokemon&accion=buscar&evento=filtrar" method="POST">
                <div class="form-group">
                    <select name="busquedaPor" id="busquedaPor" class="form-control">
                        <option value="id">ID</option>
                        <option value="nombre">Nombre</option>
                    </select>
                    <select name="tipoBusqueda" id="tipoBusqueda" class="form-control">
                        <option value="empiezaPor">Empieza Por</option>
                        <option value="acabaEn">Acaba en</option>
                        <option value="contiene">Contiene</option>
                        <option value="igualA">Igual a</option>
                    </select>
                    <input type="text" required class="form-control" id="busqueda" name="busqueda" placeholder="Buscar por Usuario">
                </div>
                <button type="submit" class="btn btn-success" name="Filtrar"><i class="fas fa-search"></i> Buscar</button>
            </form>
            <form action="index.php?tabla=pokemon&accion=listar" method="POST">
                <button type="submit" class="btn btn-info" name="Todos"><i class="fas fa-list"></i> Listar</button>
            </form>
        </div>
        <?php if ($mostrarDatos): ?>
            <center>
            <table class="table-list table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Imagen</th>
                        <th scope="col">ID</th>
                        <th scope="col">Pokemon</th>
                        <th scope="col">Ataque</th>
                        <th scope="col">Defensa</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Evolucion</th>
                        <th scope="col">Eliminar</th>
                        <th scope="col">Ver</th>
                        <th scope="col">Modificar Evolución</th>
                        <th scope="col">Modificar Imagenes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pokemons as $pokemon):
                        $id = $pokemon->id;
                       
                        ?>
                        <tr>
                            <td> <img src="<?=$pokemon->imagen?>/<?=$pokemon->nombre ?>.gif" alt=""></td>
                            <th scope="row"><?= $pokemon->id ?></th>
                            <td><?= $pokemon->nombre ?></td>
                            <td><?= $pokemon->ataque ?></td>
                            <td><?= $pokemon->defensa ?></td>
                            <td><?= $pokemon->tipo ?></td>
                            <td><?= $pokemon->nivel ?></td>
                            <td><?= $pokemon->id_evolucion ?></td>
                            <td>
                            <?php 
                                $disable = "";
                                $ruta = "index.php?tabla=pokemon&accion=borrar&id={$id}";
                                if (isset($pokemon->esBorrable) && $pokemon->esBorrable == false) {
                                    $disable = "disabled";
                                    $ruta = "#";
                                }
                                ?>
                                <button class="btn-listar-borrar <?= $disable ?>"><a href="<?= $ruta ?>">Borrar</a></button>
                            </td>
                            <td>
                                <button class="btn-listar-ver"><a href="index.php?tabla=pokemon&accion=ver&id=<?=$id?>"> Ver</a></button>
                        
                            </td>
                            <td>
                                <button class="btn-option"><a href="index.php?tabla=pokemon&accion=modificarEvolucion&id=<?=$id?>&nombre=<?=$pokemon->nombre?>">Modificar Evolución</a></button>
                            </td>
                            <td>
                                <button class="btn-option"><a href="index.php?tabla=pokemon&accion=modificarImagenes&id=<?=$id?>&nombre=<?=$pokemon->nombre?>">Modificar Imagenes</a></button>
                            </td>
                        </tr>
                        <?php
                    endforeach;

                    ?>
                </tbody>
            </table>
                
            </center>
        <?php endif; ?>
    </div>
</main>
