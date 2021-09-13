<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mawuekom\PasswordHistory\Services\PasswordHistoryChecker;

class PasswordReset
{
    private $passwordHistoryChecker;

    public function __construct(PasswordHistoryChecker $passwordHistoryChecker)
    {
        $this->passwordHistoryChecker = $passwordHistoryChecker;
    }

    
    /**
     * Handle password reset.
     *
     * @param string $email
     * @param string $token
     * @param string $password
     *
     * @return array
     */
    public function __invoke(string $email, string $token, string $password): array
    {
        $tokenData = DB::table('password_resets') ->where('token', $token) ->first();
        
        if (!$tokenData) {
            throw new Exception(trans('passauth::messages.invalid_token'), Response::HTTP_BAD_REQUEST);
        }

        $user = config('passauth.user.model')::where('email', $email) ->first();

        if (is_null($user)) {
            throw ValidationException::withMessages(['email' =>trans('passauth::messages.email_not_matching')]);
        }

        $password_history_enabled = config('passauth.password_history.enable');

        if ($password_history_enabled) {
            $this ->passwordHistoryChecker ->validatePassword($user, $password);
        }

        $user ->password = $password;
        $user ->save();

        return success_reply(trans('userly::messages.password_changed'));
    }
}