<?php

namespace Mawuekom\Passauth\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        $user = config('passauth.user.model')::where('email', $email) ->first();

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

        return success_reply(trans('userly::messages.sent_password_reset_link'));
    }
}