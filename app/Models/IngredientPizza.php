<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientPizza extends Model
{
    use HasFactory;

    protected $table = 'ingredient_pizza';

    protected $fillable = [
        'pizza_id',
        'ingredient_id',
        'order',
    ];

    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }

    public static function boot(): void
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->pizza->recalculatePrice();
        });

        static::created(function ($model) {
            $model->pizza->recalculatePrice();
        });
    }
}
