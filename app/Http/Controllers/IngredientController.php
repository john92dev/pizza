<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredient;
use App\Http\Requests\UpdateIngredient;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function store(StoreIngredient $request)
    {
        $data = $request->validated();

        return Ingredient::create($data);
    }

    public function update(UpdateIngredient $request, Ingredient $ingredient)
    {
        $data = $request->validated();
        $ingredient->update($data);

        return $ingredient;
    }

    public function index()
    {
        return Ingredient::get();
    }

    public function show(Ingredient $ingredient)
    {
        return $ingredient;
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
    }
}
