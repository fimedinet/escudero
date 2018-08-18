<?php

namespace FimediNET\Escudero\Facades;

use Illuminate\Support\Facades\Facade;

class Escudero extends Facade
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
