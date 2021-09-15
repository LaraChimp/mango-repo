<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaraChimp\MangoRepo\Tests\Fixtures\Database\Factories\FooFactory;

class Foo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return FooFactory::new();
    }
}
