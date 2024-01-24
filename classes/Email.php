<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $name;
    protected $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '80e241bdd9123e';
        $mail->Password = '3923ee8d75c42e';

        $mail->setFrom('admin@uptask.com');
        $mail->addAddress('admin@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hola " . $this->name . "</strong> has Creado tu Cuenta en UpTask, debes confirmarla en el siguiente enlace: </p>";
        $content .= "<p>Presiona Aquí: <a href='http://localhost:3000/confirm?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $content .= "<p>Si tu no creaste esta Cuenta, puedes ignorar este mensaje</p>";
        $content .= '</html>';

        $mail->Body = $content;

        // Enviar el mail
        $mail->send();
    }

    public function sendInstructions()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '80e241bdd9123e';
        $mail->Password = '3923ee8d75c42e';

        $mail->setFrom('admin@uptask.com');
        $mail->addAddress('admin@uptask.com', 'uptask.com');
        $mail->Subject = 'Reestablece tu Contraseña';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p><strong>Hola " . $this->name . "</strong> has olvidado tu contraseña?, puedes reestablecerla en el siguiente link: </p>";
        $content .= "<p>Presiona Aquí: <a href='http://localhost:3000/reset?token=" . $this->token . "'>Reestablecer Contraseña</a></p>";
        $content .= "<p>Si no solicitaste este cambio, puedes ignorar este mensaje</p>";
        $content .= '</html>';

        $mail->Body = $content;

        // Enviar el mail
        $mail->send();
    }
}
