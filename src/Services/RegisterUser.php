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
     * @param string $callback_url
     * @param string $view
     *
     * @return array
     */
    public function __invoke(StoreUserDTO $storeUserDTO)
    {
        $user = app(StoreUserAction::class) ->execute($storeUserDTO);

        return success_response(trans('passauth::messages.user_account_created'), $user, 201);
    }
}