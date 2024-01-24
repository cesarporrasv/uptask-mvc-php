<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <div class="container-sm">
        <div class="container-new-task">
            <button 
                type="button"
                class="add-task"
                id="add-task"
            >&#43; Nueva Tarea</button>
        </div>
    </div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php  
$script ='
    <script src="build/js/tasks.js" ></script>
';
?>