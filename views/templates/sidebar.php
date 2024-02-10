<aside class="sidebar">
    <div class="container-sidebar">
        <h2>UpTask</h2>

        <div class="close-menu">
            <img id="close-menu" src="build/img/cerrar.svg" alt="close image">
        </div>

    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($title === 'Proyectos') ? 'active' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($title === 'Crear Proyecto') ? 'active' : ''; ?>" href="/create-project">Crear Proyecto</a>
        <a class="<?php echo ($title === 'Perfil') ? 'active' : ''; ?>" href="/profile">Perfil</a>
    </nav>

    <div class="sign-off-mobile">
        <a href="/logout" class="sign-off">Cerrar Sesión</a>
    </div>
</aside>