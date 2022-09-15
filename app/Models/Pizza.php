<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'selling_price',
    ];

    public function ingredients() {
        return $this->hasMany(IngredientPizza::class)->with('ingredient')->orderBy('order');
    }
}
