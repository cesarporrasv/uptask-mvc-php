<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

    <form class="form" method="POST" action="/create-project">
        <?php include_once __DIR__ . '/form-project.php'; ?>
        <input type="submit" value="Crear Proyecto">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>