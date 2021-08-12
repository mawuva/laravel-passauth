<?php

namespace Domain\Passauth\Traits;

use Mawuekom\Passauth\Notifications\EmailVerificationNotification;
use Mawuekom\Passauth\Notifications\ResetPasswordNotification;

trait CustomNotifications
{
    /**
     * Send the email verification notification.
     * 
     * @param string $callback_url
     * @param string $view
     *
     * @return void
     */
    public function sendEmailVerificationNotification($callback_url = null, $view = null): void
    {
        $this ->notify(new EmailVerificationNotification($callback_url, $view));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token, $callback_url = null, $view = null)
    {
        $this->notify(new ResetPasswordNotification($token, $callback_url, $view));
    }
}