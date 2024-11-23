<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3">Encuentra tu coche de alquiler al mejor precio</h3>
        </div>
    </div>
    <div class="container-down">
        <form class="formulario" action="generar_tarifa" method="post" enctype="multipart/form-data">
            <div class="register__datos">
                <div class="register__item calendar-1">
                    <label class="register__description" for="fechaRecog">Fecha de recogida</label>
                    <input class="register__entrada" type="date" name="fechaRecog">
                </div>
                <div class="register__item calendar-2">
                    <label class="register__description register__description--menor" for="fechaDev">Fecha de devolucion</label>
                    <input class="register__entrada" type="date" name="fechaDev">
                </div>

                <div class="boton"> <input class="boton__enviar" type="submit" name="enviar" value="Calcular"></div>
            </div>
        </form>
    </div>
    <?php
    $bandera = false;
    $total_dias = 0;
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
     * Obtiene el precio base del fichero si no existe lo crea y le introduce el valor de 60 por defecto.
     */
    function obtenerPrecioBase(): float
    {

        $rutaArchivo = 'resources' . DIRECTORY_SEPARATOR . 'precio_base.txt';

        if (!file_exists($rutaArchivo)) {
            file_put_contents($rutaArchivo, "60");
        }

        $precios = file('resources' . DIRECTORY_SEPARATOR . 'precio_base.txt');

        foreach ($precios as $precio) {
            $precioFiltrado = (float) filtrado($precio);
        }
        return $precioFiltrado;
    }
    /**
     * Determina el numero total de dias pasados entre la fecha inicial y la final
     */
    function dias_pasados($fecha_inicial, $fecha_final):int
    {
        $inicio = new DateTime($fecha_inicial);
        $final = new DateTime($fecha_final);

        $diferencia = $inicio->diff($final);

        return $diferencia->days + 1;
    }
    /**
     * Calcula el descuento en funcion del numero de dias pasado por parametro
     */
    function calcularDescuento(int $totalDias): float
    {
        $descuento = 0;

        if ($totalDias >= 35) {
            $descuento += 0.30;
        } else if ($totalDias >= 25) {
            $descuento += 0.25;
        } else if ($totalDias >= 20) {
            $descuento += 0.20;
        } else if ($totalDias >= 10) {
            $descuento += 0.15;
        }

        return $descuento;
    }
    /**
     * Comprueba si las fechas introducidas son correctas
     */
    function comprobarFechas(String $fecha1, String $fecha2): string
    {
        $resultado = "";

        $hoy = date("Y-m-d");

        if ($fecha1 < $hoy || $fecha2 < $hoy || $fecha2 < $fecha1) {
            $resultado = "Error al introducir las fechas";
        } else {

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha1)) {

                list($anio, $mes, $dia) = explode('-', $fecha1);

                $resultado = (checkdate((int)$mes, (int)$dia, (int)$anio)) ? "" : "Error al introducir las fechas";
            } else {
                $resultado = "Error al introducir las fechas.";
            }

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha2)) {

                list($anio, $mes, $dia) = explode('-', $fecha2);

                $resultado = (checkdate((int)$mes, (int)$dia, (int)$anio)) ? "" : "Error al introducir las fechas";
            } else {
                $resultado = "Error al introducir las fechas.";
            }
        }
        return $resultado;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["enviar"])) {

        $errores = [];

        // Comprobamos el campo de archivo 'imagen' y lo validamos si existe
        $primeaFecha = isset($_POST['fechaRecog']) ? filtrado($_POST['fechaRecog']) : '';
        $segundaFecha = isset($_POST['fechaDev']) ? filtrado($_POST['fechaDev']) : '';
        $errores[] = comprobarFechas($primeaFecha, $segundaFecha);

        foreach ($errores as $error) {
            if ($error != "") {
                $bandera = true;
            }
        }

        if (!$bandera) {
            $total_dias = dias_pasados($primeaFecha, $segundaFecha);
        }
    }
    ?>
    <div class="container__table">
        <?php
        if ($total_dias > 0) {

            require 'tabla/tabla.php';
        }
        ?>
    </div>
</section>