<?php

namespace Modules\Subscriber\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class WelcomeNotification extends Notification
{
    use Queueable;

    public $password = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line(sprintf('Welcome to %s.', config('app.name')))
                    ->line(sprintf('Your registrtion done successully with %s.', config('app.name')))
                    ->line('Your current credentails for app is below:')
                    ->line(new HtmlString(sprintf('<span style="padding-left: 30px; color:#0487c5;">Username: <b>%s</b><span>', $notifiable->email)))
                    ->line(new HtmlString(sprintf('<span style="padding-left: 30px; color:#0487c5;">Password: <b>%s</b><span>', $this->password)))
                    ->line(new HtmlString('<span style="font-weight: 600; color:#cb0404;">Note: </span> Please change your password as soon as possible.' ))
                    ->action('Click Here For Login', config('app.url'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
