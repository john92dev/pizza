<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientPizza extends Model
{
    use HasFactory;

    protected $table = 'ingredient_pizza';

    protected $fillable = [
        'pizza_id',
        'ingredient_id',
        'order',
    ];

    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }
}
