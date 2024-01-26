<?php

namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController
{
    public static function index()
    {
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
            } else {
                $response = [
                    'type' => 'success',
                    'message' => 'Tarea agregada correctamente'
                ];
                echo json_encode($response);
            }
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}
