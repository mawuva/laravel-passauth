<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;
use Mawuekom\CustomUser\Facades\CustomUser;

class SendEmailVerificationNotification
{
    /**
     * Handle send email verification notification.
     * 
     * @param int|string $id
     * @param string $callback_url
     * @param string $view
     * 
     * @return array
     */
    public function __invoke($id, $callback_url = null, $view = null): array
    {
        $user = CustomUser::getUserById($id);

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }

        if ($user ->hasVerifiedEmail()) {
            throw new Exception(trans('passauth::messages.account_already_verified'), Response::HTTP_BAD_REQUEST);
        }

        $user ->sendEmailVerificationNotification($callback_url, $view);

        return success_response(null, trans('passauth::messages.sent_verification_link'));
    }
}