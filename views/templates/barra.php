<div class="barra-mobile">
    <a href="/dashboard"><h1>UpTask</h1></a>

    <div class="menu">
        <img id="mobile-menu" src="build/img/menu.svg" alt="imagen menu">
    </div>
</div>

<div class="barra">
    <div class="info-usuario">
        <div class="letra-nombre"><?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?></div>
        <div class="texto-usuario">
            <p><?php echo $_SESSION['nombre']; ?></p>
            <p><?php echo $_SESSION['email']; ?></p>
        </div>
    </div>
    
    <a href="/logout" class="cerrar-sesion" id="cerrar-sesion">Cerrar Sesión</a>
</div>