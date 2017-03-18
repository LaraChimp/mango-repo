<?php

namespace LaraChimp\MangoRepo\Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestRepository extends AbstractTestCase
{
    use DatabaseTransactions;

    /**
     * Tests that EloquentModel annotation works
     * and we are able to get the Model when building
     * a repository.
     *
     * @return void
     */
    public function testEloquentAnnotationOnRepositories()
    {
        $users = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\UserRepository::class);
        $this->assertInstanceOf(\LaraChimp\MangoRepo\Tests\Fixtures\Models\User::class, $users->getModel());
    }

    /**
     * Tests that we can use the Const Target instead of
     * annotations for booting repositories.
     *
     * @return void
     */
    public function testRepositoriesWithTargetConst()
    {
        $foos = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository::class);
        $this->assertInstanceOf(\LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class, $foos->getModel());
    }

    /**
     * Test that the all method returns
     * all models in the Database.
     *
     * @return void
     */
    public function testAllMethod()
    {
        factory(\LaraChimp\MangoRepo\Tests\Fixtures\Models\User::class)->create([
            'email' => 'hello@larachimp.com',
            'name'  => 'User 1',
        ]);
        factory(\LaraChimp\MangoRepo\Tests\Fixtures\Models\User::class)->create([
            'email' => 'hello2@larachimp.com',
            'name'  => 'User 2',
        ]);

        $users = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\UserRepository::class);
        $usersInDb = $users->all();

        $this->assertInstanceOf(Collection::class, $usersInDb);
        $this->assertCount(2, $usersInDb);

        $usersWithNamesAndEmailsOnly = $users->all(['name', 'email']);
        $this->assertEquals([
            [
                'email' => 'hello@larachimp.com',
                'name'  => 'User 1',
            ],
            [
                'email' => 'hello2@larachimp.com',
                'name'  => 'User 2',
            ],
        ], $usersWithNamesAndEmailsOnly->toArray());
    }

    /**
     * Test the paginate method on repositories.
     *
     * @return void
     */
    public function testPaginateMethod()
    {
        factory(\LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class, 20)->create();
        $foos = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository::class);

        $foosPaginated = $foos->paginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $foosPaginated);
        $this->assertCount(10, $foosPaginated);
    }

    /**
     * Test the simple paginate method works as expected.
     *
     * @return void
     */
    public function testSimplePaginateMethod()
    {
        factory(\LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class, 20)->create();
        $foos = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository::class);

        $foosPaginated = $foos->simplePaginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\Paginator::class, $foosPaginated);
        $this->assertCount(10, $foosPaginated);
    }

    /**
     * Test the Create method of the Repository.
     *
     * @return void
     */
    public function testCreateMethod()
    {
        $fooEloquentModel = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class);
        $foos = $this->app->make(\LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository::class);

        $this->assertEquals(0, $fooEloquentModel->count());

        $foo = $foos->create([
            'name' => 'FooBar',
        ]);

        $this->assertEquals(1, $fooEloquentModel->count());
        $this->assertEquals($foo->name, $fooEloquentModel->first()->name);
    }
}
