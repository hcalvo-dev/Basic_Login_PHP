<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3">Datos de usuarios</h3>
        </div>
    </div>
    <div class="container-down">
        <div class="contenido--up">
            <?php
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

            $archivo = 'json' . DIRECTORY_SEPARATOR . 'usuarios.json';
            if (file_exists($archivo)) {

                $datos_json = file_get_contents($archivo);
                $usuarios = json_decode($datos_json, true);

                if (!empty($usuarios)) {

                    if (isset($_GET['user'])) {
                        $id = (int)filtrado($_GET['user']);
                    } else {
                        $id = 1;
                        header("Location: ?user=$id");
                        exit;
                    }

                    if ($id < 1 || $id > count($usuarios)) {
                        require 'recursos/errores.php';
                    } else {

                        $campos = ["nombre", "apellidos", "dni", "email", "fecha_nacimiento", "imagen"];

                        $contador = 0;

                        foreach ($campos as $value) {
                            $$value = $usuarios[$id - 1][$value];

                            if ($contador == 0) {
                                echo "<div class=\"contenido--left\">";
                            }
                            if ($contador == 3) {
                                echo "</div> <div class=\"contenido--right\">";
                            }

                            echo "<div class=\"palabra\">";

                            echo "<label class=\"title title--left\">" . ucfirst($value) . ":</label>";

                            if ($value == "imagen") {
                                echo "<img class=\"container-img\" src=\"img_formulario/" . $$value . "\" alt=\"#\">";
                            } else {
                                echo "<p class=\"error__campo\">" . $$value . "</p>";
                            }

                            echo "</div>";
                            $contador++;
                        }

                    require 'recursos/calcular_pagina.php';
                        
                        echo "</div>";
                        echo "<div class=\"user-botton\">
                         <a href=\"usuarios?user=$paginaAnterior\" class=\"mid__link\">Anterior</a>
                         <a href=\"usuarios?user=$paginaSiguiente\" class=\"mid__link\">Siguiente</a>
                         </div>";
                    }
                } else {
                    require 'recursos/errores.php';
                }
            } else {
                require 'recursos/errores.php';
            }

            ?>

        </div>

</section>