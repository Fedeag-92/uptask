<aside class="sidebar">
    <div class="contenedor-sidebar">
        <a href="/dashboard">UpTask</a>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>
    
    <div class="info-usuario">
        <div class="letra-nombre"><?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?></div>
        <div class="texto-usuario">
            <p><?php echo $_SESSION['nombre']; ?></p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyecto') ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil' || $titulo === 'Cambiar Password') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>