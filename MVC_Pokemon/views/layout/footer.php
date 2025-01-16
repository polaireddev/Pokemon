<?php
$rutaJs= GenerarRutaJs($vista);
echo (file_exists($rutaJs))?"<script src={$rutaJs}></script>":"";

//footer?????
?>

</body>
</html>