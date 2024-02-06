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

    <div class="filters" id="filters">
        <div class="filters-inputs">
            <h2>Filtros:</h2>
            <div class="field">
                <label for="all">Todas</label>
                <input 
                    type="radio"
                    id="all"
                    name="filter"
                    value=""
                    checked
                />
            </div>

            <div class="field">
                <label for="done">Completadas</label>
                <input 
                    type="radio"
                    id="done"
                    name="filter"
                    value="1"
                />
            </div>

            <div class="field">
                <label for="to-do">Pendientes</label>
                <input 
                    type="radio"
                    id="to-do"
                    name="filter"
                    value="2"
                />
            </div>
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