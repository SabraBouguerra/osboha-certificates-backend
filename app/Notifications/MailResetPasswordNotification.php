<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//custom
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\ResetPassword;

class MailResetPasswordNotification extends Notification
{
    use Queueable;
    protected $pageUrl;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token=$token;
        $this->pageUrl = 'https://www.google.com/';
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
        ->from('example@example.com', 'Example')
        ->subject('أصبوحة || تغيير كلمة المرور')
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', $this->pageUrl."?token=".$this->token)
        ->line('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')])
        ->line('If you did not request a password reset, no further action is required.');
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
