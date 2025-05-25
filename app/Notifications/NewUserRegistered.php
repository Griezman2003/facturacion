<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $user;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Nuevo Usuario Registrado')
        ->line('Un nuevo usuario se ha registrado en el sistema.')
        ->line('Nombre de usuario: ' . $this->user->nombre_usuario)
        ->line('Correo: ' . $this->user->email)
        ->action('Ver Usuario', url('web/admin/dashboard')) 
        ->line('Gracias por usar nuestro sistema!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'Un nuevo usuario se ha registrado: ' . $this->user->nombre_usuario,
        ];
    }
}
