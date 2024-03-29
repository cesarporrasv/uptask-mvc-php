<?php

namespace Model;

class User extends ActiveRecord
{
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'email', 'password', 'token', 'confirm'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->current_password = $args['current_password'] ?? '';
        $this->new_password = $args['new_password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirm = $args['confirm'] ?? 0;
    }

    // Validar Login de usuarios
    public function validateLogin()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'Un Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no Válido';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'La Contraseña es Obligatoria';
        }

        return self::$alerts;
    }

    // Validacion para cuentas nuevas
    public function validateNewAccount()
    {
        if (!$this->name) {
            self::$alerts['error'][] = 'El Nombre de usuario es Obligatorio';
        }
        if (!$this->email) {
            self::$alerts['error'][] = 'Un Email es Obligatorio';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'La Contraseña es Obligatoria';
        }
        if (strlen($this->password) < 8) {
            self::$alerts['error'][] = 'La Contraseña debe tener al menos 8 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas no Coinciden';
        }
        return self::$alerts;
    }

    // Valida el email
    public function validateEmail()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'El Email es Obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no Válido';
        }
        return self::$alerts;
    }

    // Validar password
    public function validatePassword()
    {
        if (!$this->password) {
            self::$alerts['error'][] = 'La Contraseña es Obligatoria';
        }
        if (strlen($this->password) < 8) {
            self::$alerts['error'][] = 'La Contraseña debe tener al menos 8 caracteres';
        }
        return self::$alerts;
    }

    // Validar cambio de password
    public function new_password() : array
    {
        if (!$this->current_password) {
            self::$alerts['error'][] = 'Escribe la Contraseña Actual';
        }

        if (!$this->new_password) {
            self::$alerts['error'][] = 'Escribe la Contraseña Nueva';
        }

        if (strlen($this->new_password) < 8) {
            self::$alerts['error'][] = 'La Contraseña debe tener al menos 8 caracteres';
        }
        return self::$alerts;
    }

    // Comprobar password
    public function check_password() : bool
    {
        return password_verify($this->current_password, $this->password);
    }

    // Hashea password
    public function hashPassword() : void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Validar perfiles
    public function validate_profile()
    {
        if (!$this->name) {
            self::$alerts['error'][] = 'Debes Escribir un Nombre';
        }

        if (!$this->email) {
            self::$alerts['error'][] = 'Debes Escribir un Email';
        }
        return self::$alerts;
    }

    // Generar token
    public function createToken() : void
    {
        $this->token = uniqid();
    }
}
