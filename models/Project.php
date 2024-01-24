<?php

namespace Model;

use Model\ActiveRecord;

class Project extends ActiveRecord
{
    protected static $table = 'projects';
    protected static $columnsDB = ['id', 'project', 'url', 'ownerId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->project = $args['project'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->ownerId = $args['ownerId'] ?? '';
    }

    public function validateProject()
    {
        if (!$this->project) {
            self::$alerts['error'][] = 'El nombre del Proyecto es obligatorio';
        }
        return self::$alerts;
    }
}
