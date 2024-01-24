<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateLogin();

            if (empty($alerts)) {
                // Verificar que el usuario exista
                $user = User::where('email', $user->email);

                if (!$user || !$user->confirm) {
                    User::setAlert('error', 'Usuario no existe o no confirmado');
                } else {
                    // El usuario existe
                    if (password_verify($_POST['password'], $user->password)) {
                        // iniciamos Sesion
                        createSession();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    } else {
                        User::setAlert('error', 'Contraseña incorrecta');
                    }
                }
            }
        }

        $alerts = User::getAlerts();
        // Render a la vista
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'alerts' => $alerts,
        ]);
    }

    public static function logout()
    {
        createSession();
        $_SESSION = [];

        header('Location:/');
    }

    public static function create(Router $router)
    {
        $alerts = [];
        $user = new User;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);
            $alerts = $user->validateNewAccount();
            $alerts = $user->validateEmail();

            if (empty($alerts)) {
                // Comprobar usuario existe
                $userExists = User::where('email', $user->email);
                if ($userExists) {
                    User::setAlert('error', 'El Usuario ya está Registrado');
                    $alerts = User::getAlerts();
                } else {
                    // Hashear password
                    $user->hashPassword();
                    // Eliminar password2
                    unset($user->password2);
                    // Generar token
                    $user->createToken();
                    // Crear nuevo usuario
                    $output = $user->save();
                    // Enivar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendConfirmation();

                    if ($output) {
                        header('Location: /message');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/create', [
            'title' => 'Crea tu Cuenta',
            'user' => $user,
            'alerts' => $alerts,
        ]);
    }

    public static function forgot(Router $router)
    {
        $alerts = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alerts = $user->validateEmail();

            if (empty($alerts)) {
                // Buscar el usuario
                $user = User::where('email', $user->email);
                // Si usuario esta confirmado
                if ($user && $user->confirm) {
                    // Generar nuevo token
                    $user->createToken();
                    // Quitar password2
                    unset($user->password2);
                    // Actualizar usuario
                    $user->save();
                    // Enviar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();
                    // Imprimir alerta
                    User::setAlert('success', 'Hemos enviado las instrucciones a tu Email');
                } else {
                    User::setAlert('error', 'El Usuario no existe o no esta confirmado');
                }
            }
        }
        $alerts = User::getAlerts();

        // Render a la vista
        $router->render('auth/forgot', [
            'title' => 'Olvidé Contraseña',
            'alerts' => $alerts,
        ]);
    }

    public static function reset(Router $router)
    {
        $token = snz($_GET['token']);
        $show = true;
        if (!$token) header('Location: /');

        // Encontrar al usuario con el token
        $user = User::where('token', $token);
        if (empty($user)) {
            // Usuario no encontrado
            User::setAlert('error', 'Token no Válido');
            $show = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardar nuevo password
            $user->sync($_POST);
            // Validar password
            $alerts = $user->validatePassword();
            if (empty($alerts)) {
                // Hashear el nuevo password
                $user->hashPassword();
                // Quitar password2
                unset($user->password2);
                // Eliminar el token
                $user->token = '';
                // Guardar el usuario en la DB
                $output = $user->save();
                // Redireccionar
                if ($output) {
                    header('Location: /');
                }
            }
        }
        $alerts = User::getAlerts();
        // Render a la vista
        $router->render('auth/reset', [
            'title' => 'Reestablecer Password',
            'alerts' => $alerts,
            'show' => $show,
        ]);
    }

    public static function message(Router $router)
    {
        // Render a la vista
        $router->render('auth/message', [
            'title' => 'Cuenta Creada Exitosamente',
        ]);
    }

    public static function confirm(Router $router)
    {
        $token = snz($_GET['token']);
        if (!$token) header('Location: /');

        // Encontrar al usuario con el token
        $user = User::where('token', $token);
        if (empty($user)) {
            // Usuario no encontrado
            User::setAlert('error', 'Token no Válido');
        } else {
            // Confirmar cuenta
            $user->confirm = 1;
            $user->token = "";
            unset($user->password2);
            // Guardar en DB
            $user->save();
            User::setAlert('success', 'Cuenta comprobada correctamente');
        }
        $alerts = User::getAlerts();
        // Render a la vista
        $router->render('auth/confirm', [
            'title' => 'Confirma tu cuenta UpTask',
            'alerts' => $alerts,
        ]);
    }
}
