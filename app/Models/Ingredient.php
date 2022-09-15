<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cost_price',
    ];

    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class);
    }

    public static function boot(): void
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->cost_price = 0;
            $model->save();
            foreach ($model->pizzas as $pizza) {
                $pizza->recalculatePrice();
            }
        });

        static::updated(function ($model) {
            foreach ($model->pizzas as $pizza) {
                $pizza->recalculatePrice();
            }
        });
    }
}
