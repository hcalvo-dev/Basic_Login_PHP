<?php

$archivo = 'json' . DIRECTORY_SEPARATOR . 'usuarios.json';

if (!file_exists($archivo)) {
    $nuevoArchivo = fopen("json/usuarios.json", "w");
    fclose($nuevoArchivo);
}

$datos_json = file_get_contents($archivo);
$usuarios = json_decode($datos_json, true);

if (empty($usuarios)) {
    $nuevo_id = 1;
} else {
    $nuevo_id = count($usuarios) + 1;
}

$nombre = ucfirst(strtolower($nombre));
$apellidos = ucfirst(strtolower($apellidos));

if (empty($imagen)) {
    $imagen = "user-generico.jpg";
}

$nuevo_usuario = [
    'id' => $nuevo_id,
    'nombre' => $nombre,
    'apellidos' => $apellidos,
    'dni' => $dni,
    'email' => $email,
    'contrasena' => $contrasena,
    'fecha_nacimiento' => $fecha_nac,
    'imagen' => $imagen,
    'fecha_registro' => date('Y-m-d H:i:s')
];

$usuarios[] = $nuevo_usuario;
file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));

?>

<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3 h3--centro">Registro realizado exitosamente!</h3>
        </div>
</section>