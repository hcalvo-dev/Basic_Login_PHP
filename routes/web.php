<?php

$request = htmlspecialchars(explode('?', $_SERVER['REQUEST_URI'])[0]);


// Lista blanca de rutas permitidas
$allowed_routes = [
    '/' => 'home.php',
    '/home' => 'home.php',
    '/generar_tarifa' => 'generar_tarifa.php',
    '/modificar_precio_base' => 'modificar_precio_base.php',
    '/pagina_alta' => 'pagina_alta.php',
    '/usuarios' => 'usuarios.php'
];
if (array_key_exists($request, $allowed_routes)) {
    require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $allowed_routes[$request];
} else {

    // Manejar rutas no encontradas
    http_response_code(404);
    require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . '404.php';
}
