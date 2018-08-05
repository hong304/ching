<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationKeyCreatedNotification extends Notification
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
        $subject[0] = "Activate Your Account – Food Inspiration Awaits!";
        $subject[1] = "Please Activate Your Account at ChingHeHuang.com";
        $subject[2] = "Let's get you started to Wok On!";

        $rand = rand(0,2);

        return (new MailMessage)
            ->subject($subject[$rand])
            ->view('emails.registration-verify-mail', ['activation_key' => $this->activationKey->activation_key, 'email' => $notifiable->email, 'user' => $this->user]);
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
