<?php

namespace Mawuekom\Passauth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Passauth\Skeleton\SkeletonClass
 */
class PassauthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-passauth';
    }
}
