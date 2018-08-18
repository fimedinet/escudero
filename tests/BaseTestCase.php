<?php

namespace Tests;

use FimediNET\Escudero\EscuderoServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return Alariva\EmailDomainBlacklist\EmailDomainBlacklistServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [EscuderoServiceProvider::class];
    }
}
