<?php

use Orchestra\Testbench\TestCase;
use LaraChimp\MangoRepo\ServiceProvider;

class TestRepository extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
