<section class="container-left">
    <div class="container-up">
        <div class="container__title">
            <h3 class="h3">Crear Cuenta</h3>
        </div>
        <div class="container-down">
            <form class="form" action="pagina_alta" method="post" enctype="multipart/form-data">
                <div class="contenido--up">
                    <div class="contenido--left">
                        <div class="palabra">
                            <label for="nombre" class="title title--left">Nombre:</label>
                            <input type="text" class="palabra__input" name="nombre" />
                        </div>
                        <div class="palabra">
                            <label for="apellidos" class="title title--left">Apellidos:</label>
                            <input type="text" class="palabra__input" name="apellidos" />
                        </div>
                        <div class="palabra">
                            <label for="dni" class="title title--left">DNI:</label>
                            <input type="text" class="palabra__input" name="dni" />
                        </div>
                    </div>
                    <div class="contenido--right">
                        <div class="palabra">
                            <label for="email" class="title title--left">Email:</label>
                            <input type="text" class="palabra__input" name="email" />
                        </div>
                        <div class="palabra">
                            <label for="contrasena" class="title title--left">Contraseña:</label>
                            <input type="password" class="palabra__input" name="contrasena" />
                        </div>
                        <div class="palabra">
                            <label for="fecha_nac" class="title title--left">Fecha Nacimiento:</label>
                            <input type="date" class="register__entrada" name="fecha_nac" />
                        </div>
                        <div class="palabra">
                            <label for="imagen" class="title title--left">Adjuntar Imagen:</label>
                            <input type="file" class="palabra__input" name="imagen" id="imagen" />
                        </div>
                    </div>
                </div>
                <div class="contenido--down">
                    <div class="enviar">
                        <input type="submit" class="boton__enviar" name="enviar" value="Enviar" />
                    </div>
                </div>
            </form>
        </div>
</section>