<?php

namespace Controllers;

use Model\Project;
use Model\User;
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
        $alerts = [];

        $user = User::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);

            $alerts = $user->validate_profile();

            if (empty($alerts)) {

                // Revisar que el email no exista
                $userExists = User::where('email', $user->email);

                if ($userExists && $userExists->id !== $user->id) {
                    // Mostrar mensaje de error
                    User::setAlert('error', 'Email ya existente');
                    $alerts = $user->getAlerts();
                } else {
                    // Guardar el usuario
                    $user->save();

                    User::setAlert('success', 'Guardado Correctamente');
                    $alerts = $user->getAlerts();

                    // Asignar nuevo nombre
                    $_SESSION['name'] = $user->name;
                }
            }
        }


        $router->render('dashboard/profile', [
            'title' => 'Perfil',
            'user' => $user,
            'alerts' => $alerts,
        ]);
    }

    public static function change_password(Router $router)
    {
        createSession();
        isAuth();
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::find($_SESSION['id']);

            // Sincronizar datos del usuario
            $user->sync($_POST);

            $alerts = $user->new_password();

            if (empty($alerts)) {
                $output = $user->check_password();

                if ($output) {

                    $user->password = $user->new_password;

                    // Eliminar propiedades no necesarias
                    unset($user->current_password);
                    unset($user->new_password);

                    // Hashear nuevo password
                    $user->hashPassword();

                    // Guardar el nuevo password
                    $output = $user->save();

                    if ($output) {
                        User::setAlert('success', 'Contraseña Actualizada Correctamente');
                        $alerts = $user->getAlerts();
                    }
                } else {
                    User::setAlert('error', 'Contraseña Actual Incorrecta');
                    $alerts = $user->getAlerts();
                }
            }
        }

        $router->render('dashboard/change-password', [
            'title' => 'Cambiar Contraseña',
            'alerts' => $alerts,
        ]);
    }
}
