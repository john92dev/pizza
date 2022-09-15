<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'selling_price',
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('order', 'id')->orderBy('order');
    }

    public function recalculatePrice(): void
    {
        $this->selling_price = $this->ingredients()->sum('cost_price') * 1.5;
        $this->save();
    }
}
