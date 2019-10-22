<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory = app()->make(Illuminate\Database\Eloquent\Factory::class);

$factory->define(LaraChimp\MangoRepo\Tests\Fixtures\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
        'is_active'      => true,
    ];
});

$factory->define(LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(LaraChimp\MangoRepo\Tests\Fixtures\Models\Bar::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'is_active' => true,
    ];
});
