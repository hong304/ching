<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RemindActivationNotification extends Notification
{
    use Queueable;

    protected $activationKey;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * SendActivationEmail constructor.
     * @param $activationKey
     */
    public function __construct($activationKey, $user)
    {
        $this->activationKey = $activationKey;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Have you activated your account yet?")
            ->view('emails.remind-activation-mail', ['activation_key' => $this->activationKey->activation_key, 'email' => $notifiable->email, 'user' => $this->user]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
