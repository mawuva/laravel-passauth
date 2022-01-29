<?php

namespace Mawuekom\Passauth\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Mawuekom\CustomUser\Actions\CheckUserCredentialsAction;

class PasswordForgot
{
    /**
     * Handle password request
     *
     * @param string $email
     * @param string $callback_url
     * @param string $view
     *
     * @return array
     */
    public function __invoke(string $email, $callback_url = null, $view = null): array
    {
        $user = app(CheckUserCredentialsAction::class) ->execute($email);

        if (is_null($user)) {
            throw ValidationException::withMessages(['email' =>trans('passauth::messages.email_not_matching')]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'         => $user ->email, 
            'token'         => $token, 
            'created_at'    => Carbon::now()
        ]);

        $user ->sendPasswordResetNotification($token, $callback_url, $view);

        return success_response(null, trans('passauth::messages.sent_password_reset_link'));
    }
}