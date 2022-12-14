<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientPizza;
use App\Http\Requests\UpdateIngredientPizza;
use App\Models\IngredientPizza;

class IngredientPizzaController extends Controller
{
    public function store(StoreIngredientPizza $request): IngredientPizza
    {
        $data = $request->validated();

        return IngredientPizza::create($data);
    }

    public function update(UpdateIngredientPizza $request, IngredientPizza $ingredientPizza): IngredientPizza
    {
        $data = $request->validated();

        $ingredientPizza->update($data);

        return $ingredientPizza;
    }

    public function destroy(IngredientPizza $ingredientPizza): void
    {
        $ingredientPizza->delete();
    }
}
