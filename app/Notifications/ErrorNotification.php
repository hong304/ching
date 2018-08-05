<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\Auth;

class ErrorNotification extends Notification
{
    use Queueable;
    private $error;
    private $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($error, $url)
    {
        $this->error = $error;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $error = $this->error;
        $url = $this->url;
        return (new SlackMessage)
            ->error()
            ->content('Error From ' . app()->environment())
            ->attachment(function ($attachment) use ($error, $url) {
                $attachment->title($error->getMessage())
                    ->fields([
                        'User'=> (Auth::check())? Auth::user()->id : "guest",
                        'Error Class Name'=>get_class($error),
                        'Error Code' => $error->getCode(),
                        'Line' => $error->getLine(),
                        'File' => $error->getFile(),
                        'From' => $url,
                    ]);
            });
    }
}
