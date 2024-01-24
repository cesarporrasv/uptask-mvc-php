
<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TaskController;

$router = new Router();

// Login-Logout
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Crear Cuentas
$router->get('/create', [LoginController::class, 'create']);
$router->post('/create', [LoginController::class, 'create']);

// Olvide mi Password
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);

// Nuevo Password
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);

// Confirmacion de Cuenta
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);

// Zona de Proyectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/create-project', [DashboardController::class, 'create_project']);
$router->post('/create-project', [DashboardController::class, 'create_project']);
$router->get('/project', [DashboardController::class, 'project']);
$router->get('/profile', [DashboardController::class, 'profile']);

// Api para Tareas
$router->get('/api/tasks', [TaskController::class, 'index']);
$router->post('/api/task', [TaskController::class, 'create']);
$router->post('/api/task/update', [TaskController::class, 'update']);
$router->post('/api/task/delete', [TaskController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkroutes();