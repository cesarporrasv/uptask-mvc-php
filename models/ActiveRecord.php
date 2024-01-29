<?php

namespace Model;

#[\AllowDynamicProperties]

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

    public $id;

    // Alertas y Mensajes
    protected static $alerts = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($type, $message)
    {
        static::$alerts[$type][] = $message;
    }

    // Validación
    public static function getAlerts()
    {
        return static::$alerts;
    }

    public function validate()
    {
        static::$alerts = [];
        return static::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultSQL($query)
    {
        // Consultar la base de datos
        $output = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($record = $output->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // liberar la memoria
        $output->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($record)
    {
        $object = new static;

        foreach ($record as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    // Identificar y unir los atributos de la BD
    public function atributes()
    {
        $atributes = [];
        foreach (static::$columnsDB as $column) {
            if ($column === 'id') continue;
            $atributes[$column] = $this->$column;
        }
        return $atributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAtributes()
    {
        $atributes = $this->atributes();
        $sanitized = [];
        foreach ($atributes as $key => $value) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Sincroniza BD con Objetos en memoria
    public function sync($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function save()
    {
        $output = '';
        if (!is_null($this->id)) {
            // actualizar
            $output = $this->update();
        } else {
            // Creando un nuevo registro
            $output = $this->create();
        }
        return $output;
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$table;
        $output = self::consultSQL($query);
        return $output;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = {$id}";
        $output = self::consultSQL($query);
        return array_shift($output);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limit)
    {
        $query = "SELECT * FROM " . static::$table . " LIMIT {$limit}";
        $output = self::consultSQL($query);
        return array_shift($output);
    }

    // Busca un registro por su token
    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE $column = '{$value}'";
        $output = self::consultSQL($query);
        return array_shift($output);
    }

    // Busca Todos los registros que pertenecen a un ID
    public static function belongsTo($column, $value)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE $column = '{$value}'";
        $output = self::consultSQL($query);
        return ($output);
    }

    // Consulta plana SQL (cuando los metodos del modelo no son suficientes)
    public static function SQL($query)
    {
        $output = self::consultSQL($query);
        return $output;
    }

    // crea un nuevo registro
    public function create()
    {
        // Sanitizar los datos
        $atributes = $this->sanitizeAtributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($atributes));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributes));
        $query .= " ') ";

        // Resultado de la consulta
        $output = self::$db->query($query);
        return [
            'output' =>  $output,
            'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function update()
    {
        // Sanitizar los datos
        $atributes = $this->sanitizeAtributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        foreach ($atributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $values);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $output = self::$db->query($query);
        return $output;
    }

    // Eliminar un Registro por su ID
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $output = self::$db->query($query);
        return $output;
    }
}
