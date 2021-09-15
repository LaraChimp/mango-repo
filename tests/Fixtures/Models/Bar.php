<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaraChimp\MangoRepo\Tests\Fixtures\Database\Factories\BarFactory;
use LaraChimp\MangoRepo\Tests\Fixtures\Models\Scopes\IsActive;

class Bar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new IsActive());
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return BarFactory::new();
    }
}
