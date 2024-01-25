<?php

namespace Controllers;

class TaskController
{
    public static function index()
    {
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            echo json_encode($_POST);
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}
