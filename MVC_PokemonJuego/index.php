<?php
ob_start();
require_once "config/sessionControl.php";
require_once("router/router.php");
require_once("views/layout/head.php");

$vista = router();
?>

<div class="container-fluid">




    <?php
    if($vista=="views/inicio.php"){
        require_once "views/layout/navbar.php";

    }
    
    ?>
    <?php
    

    if (!file_exists($vista)) echo "Error, REVISA TUS RUTAS";
    else require_once($vista);

    ?>

</div>


</div>

</div class="footer">
<?php
require_once("views/layout/footer.php");
?>
<div>