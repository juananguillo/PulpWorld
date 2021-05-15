<?php 

$block='bloqueada usuario';
if (strpos($block, 'bloqueadas') !== false) {
    $porciones = explode(" ", $block);
echo $porciones[0];
}



?>