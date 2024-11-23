<?php

define("MEDIA_DIR", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "img_formulario" . DIRECTORY_SEPARATOR);
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

function validarCampos(String $input, String $cadena): string
{
    $resultado = "";

    switch ($input) {
        case 'nombre':
            if (empty($cadena)) {
                $resultado = "Nombre,Debe de rellenar el campo nombre.";
            } else if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                $resultado = "Nombre,El nombre no puede ser de tipo numerico.";
            } else if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ]{1,20}$/', $cadena)) {
                $resultado = "Nombre,La longitud del nombre no puede ser superior a 20 caracteres.";
            }
            break;
        case 'apellidos':
            if (empty($cadena)) {
                $resultado = "Apellidos,Debe de rellenar el campo apellidos.";
            } else if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                $resultado = "Apellidos,El nombre no puede ser de tipo numerico.";
            }
            break;
        case 'dni':
            if (empty($cadena)) {
                $resultado = "Dni,El dni no puede estar vacio.";
            } else if (strlen($cadena) == 9) {
                $letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E", "T"];

                $numDni = (int) substr($cadena, 0, 8);
                $letra = substr($cadena, 8, 9);

                $calLetra = $numDni % 23;

                $resultado = ($letras[$calLetra] == strtoupper($letra)) ? "" : "Dni,Error al introducir el dni.";
            } else {
                $resultado = "Dni,Error al introducir el dni.";
            }
            break;
        case 'email':
            if (preg_match('/^\w+\@\w+\.php$/i', $cadena) || !filter_var($cadena, FILTER_VALIDATE_EMAIL)) {
                $resultado = "Email,Formato del email incorrecto.";
            }
            break;
        case 'contrasena':
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $cadena)) {
                $resultado = "Contraseña,Contraseña no valida.";
            }
            break;
        case 'fecha_nac':
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $cadena)) {

                list($anio, $mes, $dia) = explode('-', $cadena);

                $resultado = (checkdate((int)$mes, (int)$dia, (int)$anio)) ? "" : "Fecha Nacimiento,Error al introducir la fecha";
            } else {
                $resultado = "Fecha Nacimiento,Error al introducir la fecha.";
            }
            $hoy = date("Y-m-d");

            if ($cadena > $hoy) {
                $resultado = "Fecha Nacimiento,Error al introducir la fecha";
            }

            break;
        case 'imagen':
            if (!empty($cadena)) {
                if ($_FILES['imagen']['size'] > 2000000) {
                    $resultado = "Imagen,La imagen tiene un tamaño superior a 2MB";
                } else if (!preg_match('/\.(png|jpg|jpeg|gif|webp|svg)$/i', $cadena)) {
                    $resultado = "Imagen,Error al intentar subir el archivo.";
                } else if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                    if (!is_dir(MEDIA_DIR)) {
                        $resultado = "Imagen,Directorio definitivo no válido";
                    }
                } else {
                    $resultado = "Imagen,No se ha podido subir el fichero";
                }
            }
            break;
    }

    return $resultado;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["enviar"])) {

    $campos = ["nombre", "apellidos", "dni", "email", "fecha_nac", "contrasena"];
    $errores = [];

    // Recorremos cada campo esperado y aplicamos el filtrado y validación
    foreach ($campos as $campo) {
        // Si el campo está definido en $_POST, lo filtramos, si no, se le asigna una cadena vacía
        $$campo = isset($_POST[$campo]) ? filtrado($_POST[$campo]) : '';
        // Validamos el campo y almacenamos el resultado en el array de errores
        $errores[] = validarCampos($campo, $$campo);
    }

    // Comprobamos el campo de archivo 'imagen' y lo validamos si existe
    $imagen = isset($_FILES['imagen']['name']) ? filtrado($_FILES['imagen']['name']) : '';
    $errores[] = validarCampos("imagen", $imagen);


    foreach ($errores as $error) {
        if ($error != "") {
            $bandera = true;
        }
    }

    if ($bandera) {
        require 'secciones/mostrar_errores.php';
    } else {
        $idUsuario=uniqid('',true);
        if (!empty($imagen)) {

            $extension = pathinfo($imagen, PATHINFO_EXTENSION);

            $imagen = uniqid('',true).'.'.$extension;

            $nombreCompleto = MEDIA_DIR . $imagen;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreCompleto);
        }
        require 'envio_json/introducir_datos.php';
    }
} else {
    require 'secciones/formulario.php';
}
