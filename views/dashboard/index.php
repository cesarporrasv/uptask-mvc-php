<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <?php if (count($projects) === 0) { ?>
        <p class="no-projects">No Tienes Proyectos Creados! <a href="/create-project">Comienza Creando Uno Aquí</a></p>
    <?php } else { ?>
        <ul class="projects-list">
            <?php foreach($projects as $project) { ?>
                <li class="project">
                    <a href="/project?id=<?php echo $project->url; ?>">
                        <?php echo $project->project; ?>
                    </a>
                </li>
            <?php } ?>    
        </ul>
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>