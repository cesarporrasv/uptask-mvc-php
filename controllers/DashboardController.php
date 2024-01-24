<?php

namespace Controllers;

use Model\Project;
use MVC\Router;


class DashboardController
{
    public static function index(Router $router)
    {
        createSession();
        isAuth();

        $id = $_SESSION['id'];
        $projects = Project::belongsTo('ownerId', $id);

        $router->render('dashboard/index', [
            'title' => 'Proyectos',
            'projects' => $projects,
        ]);
    }

    public static function create_project(Router $router)
    {
        createSession();
        isAuth();
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);

            // Validar proyecto
            $alerts = $project->validateProject();

            if (empty($alerts)) {
                // Generar Url
                $hash = md5(uniqid());
                $project->url = $hash;
                // Guardar creador
                $project->ownerId = $_SESSION['id'];
                // Guardar proyecto
                $project->save();
                // Redireccionar
                header('Location: /project?id=' . $project->url);
            }
        }

        $router->render('dashboard/create-project', [
            'alerts' => $alerts,
            'title' => 'Crear Proyecto',
        ]);
    }

    public static function project(Router $router)
    {
        createSession();
        isAuth();

        $token = $_GET['id'];
        if (!$token) header('Location: /dashboard');
        // Revisar visita sea del propietario
        $project = Project::where('url', $token);
        if ($project->ownerId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/project', [
            'title' => $project->project,
        ]);
    }

    public static function profile(Router $router)
    {
        createSession();
        isAuth();

        $router->render('dashboard/profile', [
            'title' => 'Perfil',
        ]);
    }
}
