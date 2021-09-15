<?php

namespace LaraChimp\MangoRepo\Tests;

class TestMakeCommand extends AbstractTestCase
{
    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $this->app->make('filesystem')->disk('app')->deleteDirectory('app/Repositories');

        parent::tearDown();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // Setup default database to use sqlite :memory:
        $app['config']->set('filesystems.disks.app', [
            'driver' => 'local',
            'root'   => base_path(),
        ]);
    }

    /**
     * Test that the make repository command
     * works as expected.
     *
     * @return void
     */
    public function testMakeRepositoryCommand()
    {
        $this->artisan('mango:make', [
            'name'    => 'Repositories\FooRepository',
            '--model' => 'App\Models\Foo',
        ]);

        $this->assertFileExists(realpath($this->app->basePath().'/app/Repositories/FooRepository.php'));
        $this->assertFileEquals(
            realpath(__DIR__.'/Fixtures/files-expectations/FooRepository.php'),
            realpath($this->app->basePath().'/app/Repositories/FooRepository.php')
        );
    }

    /**
     * Test that the make repository command
     * with annotation works as expected.
     *
     * @return void
     */
    public function testMakeRepositoryAnnotatedCommand()
    {
        $this->artisan('mango:make', [
            'name'        => 'Repositories\FooRepositoryAnnotated',
            '--model'     => 'App\Models\Foo',
            '--annotated' => true,
        ]);

        $this->assertFileExists(realpath($this->app->basePath().'/app/Repositories/FooRepositoryAnnotated.php'));
        $this->assertFileEquals(
            realpath(__DIR__.'/Fixtures/files-expectations/FooRepositoryAnnotated.php'),
            realpath($this->app->basePath().'/app/Repositories/FooRepositoryAnnotated.php')
        );
    }
}
