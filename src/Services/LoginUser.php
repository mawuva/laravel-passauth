<?php

namespace Mawuekom\Passauth\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mawuekom\CustomUser\Actions\CheckUserCredentialsAction;
use Mawuekom\CustomUser\Facades\CustomUser;
use Mawuekom\Passauth\DataTransferObjects\LoginUserDTO;

class LoginUser
{
    /**
     * Handle user login.
     *
     * @param \Mawuekom\Passauth\DataTransferObjects\LoginUserDTO $loginUserDTO
     *
     * @return array
     */
    public function __invoke(LoginUserDTO $loginUserDTO): array
    {
        $user = app(CheckUserCredentialsAction::class) ->execute($loginUserDTO ->identifiant);

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'identifiant' =>trans('passauth::messages.identifiant_not_matching')
            ]);
        }

        if (!Hash::check($loginUserDTO ->password, $user ->password)) {
            throw ValidationException::withMessages([
                'password' =>trans('passauth::messages.password_not_matching')
            ]);
        }

        CustomUser::updateLastLogintAt($user);

        if (config('passauth.email_verification.enabled') && $user->email_verified_at === null) {
            return failure_response(trans('passauth::messages.account_not_yet_activated'), $user);
        }

        else {
            return success_response(trans('passauth::messages.user_login_successfully'), $user);
        }
    }
}