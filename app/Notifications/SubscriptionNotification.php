<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionNotification extends Notification
{
    use Queueable;


    protected $subscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        //
        $this->subscription = $subscription;
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
                        ->subject('Verify your email address for subscription')
                        ->greeting('Hello!')
                        ->line('Please click the button below to verify your email address so that we can alert you if and when the Lotus Wok is back in stock. ')
                        ->action('Verify Your Email', route('verify', ['verify_code' => $this->subscription->verify_code, 'email' => $notifiable->email]))
                        ->line('This will also alert you to special promotions for members only. In the meantime, check out all of Ching’s exclusive recipes and video content.')
                        ->line('See you there!');
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
