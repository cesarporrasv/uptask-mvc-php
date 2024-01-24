<div class="container login">
    <?php include_once __DIR__ .'/../templates/site-name.php'; ?>
    <div class="container-sm">
        <p class="page-description">Inicia Sesión</p>

        <?php include_once __DIR__ .'/../templates/alerts.php'; ?>

        <form class="form" method="POST" action="/">
            <div class="field">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value=""
                />
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Contraseña"
                    name="password"
                    value=""
                />
            </div>

            <input class="button" type="submit" value="Iniciar Sesión">
        </form>

        <div class="actions">
            <a href="/create">No tienes una cuenta? Crea una</a>
            <a href="/forgot">Olvidaste tu Password?</a>
        </div>
    </div> <!-- contenedor sm -->
</div>