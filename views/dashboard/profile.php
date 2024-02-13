<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

    <form action="/profile" class="form" method="POST">
        <div class="field">
            <label for="name">Nombre</label>
            <input 
                type="text"
                value="<?php echo $user->name; ?>"
                name="name"
                placeholder="Tu Nombre"
            />
        </div>

        <div class="field">
            <label for="name">Email</label>
            <input 
                type="email"
                value="<?php echo $user->email; ?>"
                name="email"
                placeholder="Tu Email"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<div class="link-div">
    <a href="/change-password" class="link">- Cambiar Contraseña -</a>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>