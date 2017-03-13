<?php

namespace LaraChimp\MangoRepo\Tests;

use Orchestra\Testbench\TestCase;
use LaraChimp\MangoRepo\MangoRepoServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        /*$this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));
        $this->artisan('migrate', ['--database' => 'testing']);*/
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            MangoRepoServiceProvider::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }
}
