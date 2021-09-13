<?php

namespace Mawuekom\Passauth\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class EmailVerificationNotification extends VerifyEmail
{
    //use Queueable;

    private $callback_url;
    private $view;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($callback_url = null, $view = null)
    {
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
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        $mailMessage = (new MailMessage);

        if (is_null($this ->view)) {
            $mailMessage ->subject(Lang::get('Verify Email Address'))
                        ->line(Lang::get('Please click the button below to verify your email address.'))
                        ->action(Lang::get('Verify Email Address'), $this->verificationUrl($notifiable))
                        ->line(Lang::get('If you did not create an account, no further action is required.'));
        }

        else {
            $mailMessage ->view($this ->view, ['url' => $this->verificationUrl($notifiable)]);
        }

        return $mailMessage;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        if (!is_null($this->callback_url)) {
            return $this->callback_url . '?verify_url=' . urlencode($verifyUrl);
        }

        return $verifyUrl;
    }
}
