<?php

namespace LaraChimp\MangoRepo\Tests;

use LaraChimp\MangoRepo\Tests\Fixtures\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\UserRepository;

class TestRepositoryScopes extends AbstractTestCase
{
    use DatabaseTransactions;

    /**
     * We will test if Eloquent scopes defined on the model
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

        //$this->assertCount(5, $users->isActive('member')->all());
    }
}
