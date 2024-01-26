<?php

namespace Model;

class Task extends ActiveRecord
{
    protected static $table = 'tasks';
    protected static $columnsDB = ['id', 'name', 'status', 'projectId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->status = $args['status'] ?? 0;
        $this->projectId = $args['projectId'] ?? '';
    }
}
