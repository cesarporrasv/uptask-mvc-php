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

    <ul class="tasks-list" id=tasks-list></ul>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php  
$script ='
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="build/js/tasks.js" ></script>
';
?>