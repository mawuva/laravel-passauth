<?php

namespace Mawuekom\Passauth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Passauth\Skeleton\SkeletonClass
 */
class Passauth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'passauth';
    }
}
