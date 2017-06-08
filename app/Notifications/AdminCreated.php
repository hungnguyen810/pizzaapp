<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminCreated extends Notification
{

    /**
     * @var
     */
    protected $admin;

    /**
     * Create a new notification instance.
     *
     * @param $admin
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
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
            ->subject('You Admin account at ' . config('app.name'))
            ->line('Your Admin account information')
            ->line('Email: ' . $this->admin->email )
            ->line('Password: ' . $this->admin->cleanPassword )
            ->line('You could use that information above to login in to system')
            ->action('Go to site', url('admin/login'))
            ->line('If you did not ask for this, please ignore this email.');
    }
}
