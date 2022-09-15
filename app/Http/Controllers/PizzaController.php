<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizza;
use App\Http\Requests\UpdatePizza;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function store(StorePizza $request): Pizza
    {
        $data = $request->validated();

        return Pizza::create($data);
    }

    public function update(UpdatePizza $request, Pizza $pizza): Pizza
    {
        $data = $request->validated();
        $pizza->update($data);

        return $pizza;
    }

    public function index()
    {
        return Pizza::orderBy('name')->get();
    }

    public function show(Pizza $pizza): Pizza
    {
        return $pizza->load('ingredients');
    }

    public function destroy(Pizza $pizza): void
    {
        $pizza->delete();
    }
}
