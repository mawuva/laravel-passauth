<?php

namespace Mawuekom\Passauth\Services;

use Mawuekom\CustomUser\Actions\StoreUserAction;
use Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO;

class RegisterUser
{
    /**
     * Handle user registration.
     *
     * @param array $data
     * @param string|null $callback_url
     * @param string|null $view
     *
     * @return array
     */
    public function __invoke(StoreUserDTO $storeUserDTO, $callback_url = null, $view = null): array
    {
        $user = app(StoreUserAction::class) ->execute($storeUserDTO);

        if (config('passauth.email_verification.enabled')) {
            $user ->sendEmailVerificationNotification($callback_url, $view);
        }

        return success_response(trans('passauth::messages.user_account_created'), $user, 201);
    }
}