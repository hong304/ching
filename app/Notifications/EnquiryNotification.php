<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class EnquiryNotification extends Notification
{
    use Queueable;


    public $enquiry;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($enquiry)
    {
        //
        $this->enquiry = $enquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $enquiry = $this->enquiry;
        return (new MailMessage)
            ->view('emails.enquiry-mail', compact('enquiry'))
            ->subject('There is an enquiry from ChingHeHuang.com');

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
        $enquiry = $this->enquiry;
        return (new SlackMessage)
            ->success()
            ->content('Enquiry from ' . app()->environment())
            ->attachment(function ($attachment) use($enquiry) {
                $attachment->title($enquiry->first_name . " " . $enquiry->last_name ." (Email: " . $enquiry->email .")")
                           ->content($enquiry->content);
            });
    }
}
