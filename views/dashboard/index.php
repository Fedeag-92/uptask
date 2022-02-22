<?php include_once __DIR__  . '/header-dashboard.php';
    include_once __DIR__ .'/../templates/alertas.php';
    if(count($proyectos) === 0 ) { ?>
        <p class="no-proyectos">No Hay Proyectos Aún <a href="/crear-proyecto">Comienza creando uno</a></p>
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) { ?>
                <li class="proyecto">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto; ?>
                    </a>
                    <div class="acciones-proyectos">
                        <div class="eliminar-proyecto">
                            <div class="texto-alerta">Eliminar</div>
                            <form action="/eliminar-proyecto" method="post" onSubmit="return foo();">
                                <input type="hidden" name="id" value="<?php echo $proyecto->id; ?>">
                                <input type="submit" value="🗑️">
                            </form>
                        </div>
                        <div class="renombrar-proyecto">
                        <div class="texto-alerta">Renombrar</div>
                            <a class="boton" href="/renombrar-proyecto?id=<?php echo $proyecto->id; ?>">🔄</a>
                        </div>
                    </div>
                    <div class="texto-progreso">
                        <?php if($proyecto->cantTotal != 0): ?>
                            <p><?php echo $proyecto->cantCompletas; ?> de <?php echo $proyecto->cantTotal; ?> Tareas Completas</br></p>
                            <p>Progreso:</p>
                        <?php else: ?>
                            <p>Sin Tareas Agregadas</p>
                        <?php endif; ?>
                    </div>
                    <?php if($proyecto->cantTotal != 0): ?>
                        <div class="contenedor-progreso w3-black w3-round-xlarge">
                            <?php if($proyecto->cantCompletas != 0): ?>
                                <div class="w3-container w3-blue w3-round-xlarge" style="width:<?php echo $proyecto->porcentaje; ?>%"><?php echo ($proyecto->porcentaje != 100) ? $proyecto->porcentaje . '%': 'COMPLETADO'; ?></div>
                            <?php else: ?>
                               <div class="w3-container">SIN PROGRESO</div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </li>
            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>

<script> 
    function foo() {
        $evento = event.target;
        event.preventDefault();
        Swal.fire({
            title: 'Estas seguro?',
            text: "Se eliminará el proyecto de manera permanente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Borrado!',
                    text: 'Proyecto borrado.',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(() => {
                    $evento.submit();
                }, 1500);
            }
            return false;
        })
    }    
</script>