<?php

namespace LaraChimp\MangoRepo\Tests;

use LaraChimp\MangoRepo\Tests\Fixtures\Models\Bar;
use LaraChimp\MangoRepo\Tests\Fixtures\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\BarRepository;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\UserRepository;

class TestRepositoryScopes extends AbstractTestCase
{
    use DatabaseTransactions;

    /**
     * We will test if Eloquent local scopes defined on the model
     * can be applied to the repository as well.
     *
     * @return void
     */
    public function testLocalScopeOnModelIsAppliedWhenQueringByRepository()
    {
        factory(User::class, 5)->create();
        factory(User::class, 3)->create([
            'is_active' => false,
        ]);

        $users = $this->app->make(UserRepository::class);
        $this->assertCount(8, $users->all());

        $this->assertCount(5, $users->isActive()->get());
    }

    /**
     * We will test if Eloquent global scopes defined on the model
     * can be applied to the repository as well.
     *
     * @return void
     */
    public function testGlobalScopeOnModelIsAppliedWhenQueringByRepository()
    {
        factory(Bar::class, 5)->create();
        factory(Bar::class, 3)->create([
            'is_active' => false,
        ]);

        $bars = $this->app->make(BarRepository::class);
        $this->assertCount(5, $bars->all());
    }

    /**
     * We will test if an inexistent method is called.
     *
     * @return void
     */
    public function testInExistentScope()
    {
        $this->expectException(\BadMethodCallException::class);

        $foos = $this->app->make(FooRepository::class);
        $foos->isNotActive()->get();
    }
}
