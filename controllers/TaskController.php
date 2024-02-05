<?php

namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController
{
    public static function index()
    {
        $projectId = $_GET['id'];

        if (!$projectId) header('Location: /dashboard');

        $project = Project::where('url', $projectId);

        createSession();

        if (!$project || $project->ownerId !== $_SESSION['id']) header('Location: /404');

        $tasks = Task::belongsTo('projectId', $project->id);

        echo json_encode(['tasks' => $tasks]);
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            createSession();

            $projectId = $_POST['projectId'];

            $project = Project::where('url', $projectId);

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $response = [
                    'type' => 'error',
                    'message' => 'Error al agregar la tarea'
                ];
                echo json_encode($response);
                return;
            }
            // Todo bien, instanciar y crear la tarea
            $task = new Task($_POST);
            $task->projectId = $project->id;
            $output = $task->save();
            $response = [
                'type' => 'success',
                'id' => $output['id'],
                'message' => 'Tarea Creada Correctamente',
                'projectId' => $project->id,
            ];
            echo json_encode($response);
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $project = Project::where('url', $_POST['projectId']);

            createSession();

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $response = [
                    'type' => 'error',
                    'message' => 'Error al actualizar la tarea'
                ];
                echo json_encode($response);
                return;
            }

            $task = new Task($_POST);
            $task->projectId = $project->id;
            $output = $task->save();
            if ($output) {
                $response = [
                    'type' => 'success',
                    'message' => 'Tarea Actualizada Correctamente',
                    'id' => $task->id,
                    'projectId' => $project->id,
                ];
                echo json_encode(['response' => $response]);
            }
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $project = Project::where('url', $_POST['projectId']);

            createSession();

            if (!$project || $project->ownerId !== $_SESSION['id']) {
                $response = [
                    'type' => 'error',
                    'message' => 'Error al eliminar la tarea'
                ];
                echo json_encode($response);
                return;
            }

            $task = new Task($_POST);
            $output = $task->delete();

            $output = [
                'output' => $output,
                'message' => 'Eliminada Correctamente',
                'type' => 'success',
            ];

            echo json_encode($output);
        }
    }
}
