<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3">Ajusta el precio según tus necesidades</h3>
        </div>
    </div>
    <div class="container-down">
        <form class="formulario" action="modificar_precio_base" method="post" enctype="multipart/form-data">
            <div class="register__datos">
                <div class="palabra">
                    <label for="precio" class="title title--center">Precio Base:</label>
                    <input type="text" class="palabra__input" name="precio" />
                    <?php if (isset($errores['precio'])): ?>
                        <p class="title--error"><?php echo $errores['precio']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="boton"> <input class="boton__enviar" type="submit" name="enviar" value="Actualizar"></div>
            </div>
        </form>
    </div>
</section>