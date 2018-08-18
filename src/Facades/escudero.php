<?php

namespace fimedinet\escudero\Facades;

use Illuminate\Support\Facades\Facade;

class escudero extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'escudero';
    }
}
