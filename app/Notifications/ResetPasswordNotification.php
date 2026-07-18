<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route(
            'password.reset',
            [
                'token' => $this->token,
                'email' => $notifiable->email,
            ],
            false
        ));

        return (new MailMessage)
            ->subject('Recuperación de contraseña')
            ->greeting('Hola')
            ->line('Hemos recibido una solicitud para restablecer la contraseña de tu cuenta.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no realizaste esta solicitud, puedes ignorar este mensaje.')
            ->salutation('Puesto de Salud Cruz Blanca');
    }
}