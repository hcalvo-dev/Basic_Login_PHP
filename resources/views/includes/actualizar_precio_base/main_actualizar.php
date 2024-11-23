<?php

$bandera = false;
/**
 * Funcion que sirve para comprobar y filtrar los valores que se han recibido de un formulario
 */
function filtrado($datos):string
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

/**
 * Comprueba si el dato introducido es correcto
 */
function comprobarPrecio(String $precio): array
{
    $resultado = [];

    if (empty($precio)) {
        $resultado['precio'] = "¡Parece que algo falló en la actualización...!";
    } else if (!is_numeric($precio)) {
        $resultado['precio'] = "¡Parece que algo falló en la actualización...!";
    } else if (!preg_match('/^\d+(\.\d+)?$/', $precio)) {
        $resultado['precio'] = "¡Parece que algo falló en la actualización...!";
    } else if ((int) $precio < 0) {
        $resultado['precio'] = "¡Parece que algo falló en la actualización...!";
    }

    return $resultado;
}

function actualizarPrecioBase($cadena):void
{

    $rutaArchivo = 'resources' . DIRECTORY_SEPARATOR . 'precio_base.txt';

        file_put_contents($rutaArchivo, $cadena);
    
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["enviar"])) {

    $errores = [];

    $cadena = isset($_POST['precio']) ? filtrado($_POST['precio']) : '';
    $erroresCampo = comprobarPrecio($cadena);
    $errores=array_merge($errores,$erroresCampo);


    foreach ($errores as $error) {
        if ($error != "") {
            $bandera = true;
        }
    }

    if ($bandera) {
        require 'secciones/formulario.php';

    } else {
        actualizarPrecioBase($cadena);
        require 'secciones/formulario.php';

    }
} else {
    require 'secciones/formulario.php';
}
