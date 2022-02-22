<?php
if($reestablecio){
    echo "<script type='text/javascript'> 
    Swal.fire(
        'Correcto!',
        'Password reestablecido con éxito',
        'success'
        ).then((result) => {
            if (result.isConfirmed) {
                window.history.pushState({}, null, 'https://uptask-prueba.herokuapp.com/');
            }
        })
            
    </script>";
}
?>

<div class="contenedor login">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                />
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>

<?php $script = '<script src="build/js/app.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>

