<?php

namespace Mawuekom\Passauth\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword
{
    //use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    private $callback_url;
    private $view;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $callback_url = null, $view = null)
    {
        $this->token = $token;
        $this ->callback_url = $callback_url;
        $this ->view = $view;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage);
        
        if (is_null($this ->view)) {
            $mailMessage ->subject(Lang::get('Reset Password Notification'))
                        ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
                        ->action(Lang::get('Reset Password'), $this ->resetUrl())
                        ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                        ->line(Lang::get('If you did not request a password reset, no further action is required.'));
        }

        else {
            $mailMessage ->view($this ->view, ['url' => $this ->resetUrl()]);
        }

        return $mailMessage;
    }

    /**
     * Generate reset url
     *
     * @return string
     */
    public function resetUrl(): string
    {
        $resetUrl = url(route('password.reset', ['token' => $this->token], false));

        if (!is_null($this->callback_url)) {
            return $this->callback_url . '?reset_url=' . urlencode($resetUrl);
        }

        return $resetUrl;
    }
}
