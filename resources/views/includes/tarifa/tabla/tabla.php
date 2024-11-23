<table class="tabla__tarifa" border="1">
    <tr class="celdas titulotabla">
        <th>Dia</th>
        <th>Precio_Base</th>
        <th>Descuento</th>
        <th>Precio</th>
    </tr>

    <?php define("PRECIO_BASE", obtenerPrecioBase());
    $fmt = new IntlDateFormatter('es_ES');
    $fmt->setPattern('EEEE MMMM');
    $prueba = new IntlDateFormatter('es_ES');
    $prueba->setPattern('EEEE d / MMMM / yyyy');
    $inicio = new DateTime($primeaFecha);
    $total = 0;

    for ($i = 1; $i <= $total_dias + 1; $i++) {
        if ($i != $total_dias + 1) {
            $diaYMes = $fmt->format($inicio);
            $fechaActual = $prueba->format($inicio);

            $separado = explode(" ", $diaYMes);

            $diaSemana = $separado[0];
            $mes = $separado[1];

            $precioBase = ($diaSemana == "viernes" || $diaSemana == "sábado" || $diaSemana == "domingo") ?  PRECIO_BASE + PRECIO_BASE * 0.1 : PRECIO_BASE;
            $precioBase = ($mes == "julio" || $mes == "agosto") ?  $precioBase + PRECIO_BASE * 0.2 : $precioBase;

            $descuento = calcularDescuento($total_dias);
            $precioDia = $precioBase - $precioBase * $descuento;
            $total += $precioDia;

            require 'contenido_tabla.php';
        } else {
            require 'total_tabla.php';
        }

        $inicio->modify('+1 day');
    }

    ?>


</table>