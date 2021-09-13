<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;

class SendEmailVerificationNotification
{
    /**
     * Handle send email verification notification.
     * 
     * @param int|string $user_id
     * @param string $callback_url
     * @param string $view
     * 
     * @return array
     */
    public function __invoke(int|string $user_id, $callback_url = null, $view = null): array
    {
        $resource = config('passauth.user.resource_name');
        $resourceKey = resolve_key($resource, $user_id);
        
        $user = config('passauth.user.model')::where($resourceKey, $user_id) ->first();

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }

        if ($user ->hasVerifiedEmail()) {
            throw new Exception(trans('userly::messages.account_already_verified'), Response::HTTP_BAD_REQUEST);
        }

        $user ->sendEmailVerificationNotification($callback_url, $view);

        return success_reply(trans('userly::messages.sent_verification_link'));
    }
}