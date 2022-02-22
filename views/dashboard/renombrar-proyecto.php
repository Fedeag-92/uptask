<?php include_once __DIR__  . '/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="proyecto">Nombre Proyecto</label>
                <input
                    type="text"
                    name="proyecto"
                    id="proyecto"
                    value="<?php echo $proyecto->proyecto; ?>"
                    placeholder="Definir un nuevo nombre"
                />
            </div>
            <div class="contador-contenedor">
            </div>
            <input type="submit" value="Renombrar Proyecto" id="btnRenProy">
        </form>
    </div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>