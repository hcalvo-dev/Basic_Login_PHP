<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3">Se ha producido un error</h3>
        </div>
        <div class="container-down">
            <div class="contenido--up">
                <?php
                $contador = 0;
                foreach ($errores as $error) {
                    if (!empty($error)) {
                        if ($contador == 0) {
                            echo "<div class=\"contenido--left\">";
                        }
                        if ($contador == 3) {
                            echo "</div> <div class=\"contenido--right\">";
                        }

                        echo "<div class=\"palabra\">";

                        $cadena = explode(",", $error);
                        echo "
                                    <label class=\"title title--left\">Campo $cadena[0]:</label>
                                    <p class=\"error__campo\">Error: $cadena[1]</p>";
                        echo "</div>";
                        $contador++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>