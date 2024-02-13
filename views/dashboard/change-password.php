<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

    <form action="change-password" class="form" method="POST">
        <div class="field">
            <label for="current_password">Contraseña Actual</label>
            <input 
                type="password"
                name="current_password"
                placeholder="Tu Contraseña Actual"
            />
        </div>

        <div class="field">
            <label for="new_password">Nueva Contraseña</label>
            <input 
                type="password"
                name="new_password"
                placeholder="Tu Nueva Contraseña"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>

</div>

<div class="link-div">
    <a href="/profile" class="link">- Volver a Perfil -</a>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>