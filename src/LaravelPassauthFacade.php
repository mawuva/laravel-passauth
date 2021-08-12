<?php

namespace Mawuekom\LaravelPassauth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\LaravelPassauth\Skeleton\SkeletonClass
 */
class LaravelPassauthFacade extends Facade
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
