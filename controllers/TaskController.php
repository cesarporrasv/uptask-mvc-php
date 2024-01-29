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
            }
            // Todo bien, instanciar y crear la tarea
            $task = new Task($_POST);
            $task->projectId = $project->id;
            $output = $task->save();
            $response = [
                'type' => 'success',
                'id' => $output['id'],
                'message' => 'Tarea Creada Correctamente'
            ];
            echo json_encode($response);
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
