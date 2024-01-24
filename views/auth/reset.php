<div class="container reset">
    <?php include_once __DIR__ . '/../templates/site-name.php'; ?>
    <div class="container-sm">
        <p class="page-description">Escribe tu nueva contraseña</p>

        <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

        <?php if ($show) { ?>

            <form class="form" method="POST">
                <div class="field">
                    <label for="password">Tu nueva contraseña</label>
                    <input type="password" id="password" placeholder="Tu Nueva Contraseña" name="password" value="" />
                </div>

                <input class="button" type="submit" value="Enviar">
            </form>

        <?php } ?>

        <div class="actions">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/create">No tienes una cuenta? Crea una</a>
        </div>
    </div> <!-- contenedor sm -->
</div>