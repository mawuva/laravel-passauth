<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mawuekom\CustomUser\Actions\CheckUserCredentialsAction;
use Mawuekom\CustomUser\Actions\UpdatePasswordAction;
use Mawuekom\Passauth\DataTransferObjects\PasswordResetDTO;

class PasswordReset
{
    /**
     * Handle password reset.
     *
     * @param \Mawuekom\Passauth\DataTransferObjects\PasswordResetDTO $passwordResetDTO
     *
     * @return array
     */
    public function __invoke(PasswordResetDTO $passwordResetDTO): array
    {
        $tokenData = DB::table('password_resets') ->where('token', $passwordResetDTO ->token) ->first();
        
        if (!$tokenData) {
            throw new Exception(trans('passauth::messages.invalid_token'), Response::HTTP_BAD_REQUEST);
        }

        $user = app(CheckUserCredentialsAction::class) ->execute($passwordResetDTO ->email);

        if (is_null($user)) {
            throw ValidationException::withMessages(['email' =>trans('passauth::messages.email_not_matching')]);
        }

        app(UpdatePasswordAction::class) ->execute($user, $passwordResetDTO ->password);

        return success_response(null, trans('passauth::messages.password_changed'));
    }
}