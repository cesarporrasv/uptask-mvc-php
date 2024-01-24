<div class="container forgot">
    <?php include_once __DIR__ . '/../templates/site-name.php'; ?>
    <div class="container-sm">
        <p class="page-description">Olvidaste tu Contraseña</p>

        <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

        <form class="form" method="POST" action="/forgot" novalidate>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email" value="" />
            </div>

            <input class="button" type="submit" value="Enviar">
        </form>

        <div class="actions">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/create">No tienes una cuenta? Crea una</a>
        </div>
    </div> <!-- contenedor sm -->
</div>