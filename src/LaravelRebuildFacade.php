<?php

namespace BukanKalengKaleng\LaravelRebuild;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BukanKalengKaleng\LaravelRebuild\Skeleton\SkeletonClass
 */
class LaravelRebuildFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rebuild';
    }
}
