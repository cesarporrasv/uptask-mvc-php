<div class="container create">
    <?php include_once __DIR__ .'/../templates/site-name.php'; ?>
    <div class="container-sm">
        <p class="page-description">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ .'/../templates/alerts.php'; ?>
        
        <form class="form" method="POST" action="/create">

        <div class="field">
                <label for="name">Nombre</label>
                <input 
                    type="text"
                    id="name"
                    placeholder="Tu Nombre"
                    name="name"
                    value="<?php echo $user->name; ?>"
                />
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value="<?php echo $user->email; ?>"
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

            <div class="field">
                <label for="password2">Repetir Contraseña</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite tu Contraseña"
                    name="password2"
                    value=""
                />
            </div>

            <input class="button" type="submit" value="Crear Cuenta">

        </form>

        <div class="actions">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/forgot">Olvidaste tu Password?</a>
        </div>
    </div> <!-- contenedor sm -->
</div>