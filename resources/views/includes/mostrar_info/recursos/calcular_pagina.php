<?php

$paginaActual=$id;
$paginaSiguiente=$paginaActual+1;
$paginaAnterior=$paginaActual-1;

if ($paginaSiguiente>count($usuarios)) {
    $paginaSiguiente=1;
}

if ($paginaAnterior<1) {
    $paginaAnterior=count($usuarios);
}

?>