<?php

namespace LaraChimp\MangoRepo\Tests;

use Illuminate\Database\Eloquent\Collection;
use LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo;
use LaraChimp\MangoRepo\Tests\Fixtures\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\FooRepository;
use LaraChimp\MangoRepo\Tests\Fixtures\Repositories\UserRepository;

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
        $users = $this->app->make(UserRepository::class);
        $this->assertInstanceOf(User::class, $users->getModel());
    }

    /**
     * Tests that we can use the Const Target instead of
     * annotations for booting repositories.
     *
     * @return void
     */
    public function testRepositoriesWithTargetConst()
    {
        $foos = $this->app->make(FooRepository::class);
        $this->assertInstanceOf(Foo::class, $foos->getModel());
    }

    /**
     * Test the all method.
     *
     * @return void
     */
    public function testAllMethod()
    {
        factory(User::class)->create([
            'email' => 'hello@larachimp.com',
            'name'  => 'User 1',
        ]);
        factory(User::class)->create([
            'email' => 'hello2@larachimp.com',
            'name'  => 'User 2',
        ]);

        $users = $this->app->make(UserRepository::class);
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
     * Test the paginate method.
     *
     * @return void
     */
    public function testPaginateMethod()
    {
        factory(Foo::class, 20)->create();
        $foos = $this->app->make(FooRepository::class);

        $foosPaginated = $foos->paginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $foosPaginated);
        $this->assertCount(10, $foosPaginated);
    }

    /**
     * Test the simplePaginate method.
     *
     * @return void
     */
    public function testSimplePaginateMethod()
    {
        factory(Foo::class, 20)->create();
        $foos = $this->app->make(FooRepository::class);

        $foosPaginated = $foos->simplePaginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\Paginator::class, $foosPaginated);
        $this->assertCount(10, $foosPaginated);
    }

    /**
     * Test the create method.
     *
     * @return void
     */
    public function testCreateMethod()
    {
        $foos = $this->app->make(FooRepository::class);

        $this->assertEquals(0, Foo::count());

        $foo = $foos->create([
            'name' => 'FooBar',
        ]);

        $this->assertEquals(1, Foo::count());
        $this->assertEquals($foo->name, Foo::first()->name);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $user = factory(User::class)->create([
            'name'  => 'SomeUser',
            'email' => 'some@email.com',
        ]);

        $users = $this->app->make(UserRepository::class);
        $hasUpdated = $users->update(['name' => 'ChangedUserName'], $user);

        $this->assertTrue($hasUpdated);
        $this->assertEquals('ChangedUserName', $user->fresh()->name);

        $hasUpdated = $users->update(['email' => 'someChanged@email.com'], $user->id);

        $this->assertTrue($hasUpdated);
        $this->assertEquals('someChanged@email.com', $user->fresh()->email);
    }

    /**
     * Test the delete method.
     *
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return void
     */
    public function testDeleteMethod()
    {
        $user1 = factory(User::class)->create([
            'name'  => 'User 1',
            'email' => 'hello@larachimp.com',
        ]);

        $user2 = factory(User::class)->create([
            'name'  => 'User 2',
            'email' => 'helloAgain@larachimp.com',
        ]);

        $users = $this->app->make(UserRepository::class);
        $users->delete($user1);
        $users->delete($user2->id);

        User::findOrFail($user1->id);
        User::findOrFail($user2->id);
    }

    /**
     * Test the find method.
     *
     * @return void
     */
    public function testFindMethod()
    {
        $user1 = factory(User::class)->create([
            'name'  => 'User 1',
            'email' => 'hello@larachimp.com',
        ]);

        $foundUser = $this->app->make(UserRepository::class)->find($user1->id);
        $this->assertEquals('User 1', $foundUser->name);

        $anotherUserNotFound = $this->app->make(UserRepository::class)->find(22);
        $this->assertNull($anotherUserNotFound);

        $userWithNameOnly = $this->app->make(UserRepository::class)->find($user1->id, ['name']);
        $this->assertEquals([
            'name' => 'User 1',
        ], $userWithNameOnly->toArray());
    }

    /**
     * Test the findOrFail method.
     *
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return void
     */
    public function testFindOrFailMethod()
    {
        $user1 = factory(User::class)->create([
            'name'  => 'User 1',
            'email' => 'hello@larachimp.com',
        ]);

        $foundUser = $this->app->make(UserRepository::class)->findOrFail($user1->id);
        $this->assertEquals('User 1', $foundUser->name);

        $this->app->make(UserRepository::class)->findOrFail(22);

        $userWithNameOnly = $this->app->make(UserRepository::class)->findOrFail($user1->id, ['name']);
        $this->assertEquals([
            'name' => 'User 1',
        ], $userWithNameOnly->toArray());
    }

    /**
     * Test the findBy method.
     *
     * @return void
     */
    public function testFindByMethod()
    {
        factory(Foo::class, 3)->create([
            'name' => 'FooBar',
        ]);

        factory(Foo::class, 4)->create([
            'name' => 'Baz',
        ]);

        factory(Foo::class, 2)->create([
            'name' => 'Bin',
        ]);

        $foos = $this->app->make(FooRepository::class);
        $fooBars = $foos->findBy([
            'name' => 'FooBar',
        ]);

        $this->assertInstanceOf(Collection::class, $fooBars);
        $this->assertCount(3, $fooBars);

        $bazs = $foos->findBy(['id' => 1, 'name' => 'FooBar']);
        $this->assertInstanceOf(Collection::class, $bazs);
        $this->assertCount(1, $bazs);

        $bins = $foos->findBy(['name' => 'Bin'], ['name']);
        $this->assertInstanceOf(Collection::class, $bins);
        $this->assertCount(2, $bins);
        $this->assertEquals([
            [
                'name' => 'Bin',
            ],
            [
                'name' => 'Bin',
            ],
        ], $bins->toArray());
    }
}
