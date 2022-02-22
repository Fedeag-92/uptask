<div class="contenedor reestablecer">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <?php if($mostrar) { ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite tu Password"
                    name="password2"
                />
            </div>

            <input type="submit" class="boton" value="Guardar Password" id="btnRestPw">
        </form>

        <?php } ?>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>

<?php $script = '<script src="build/js/app.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; ?>