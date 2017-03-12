<?php

use Orchestra\Testbench\TestCase;
use LaraChimp\MangoRepo\MangoRepoServiceProvider;

class TestRepository extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [MangoRepoServiceProvider::class];
    }
}
