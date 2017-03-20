<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Apply an is active scope filter to the model.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
