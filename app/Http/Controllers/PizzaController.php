<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizza;
use App\Http\Requests\UpdatePizza;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function store(StorePizza $request) {
        $data = $request->validated();

        return Pizza::create($data);
    }

    public function update(UpdatePizza $request, Pizza $pizza) {
        $data = $request->validated();
        $pizza->update($data);

        return $pizza;
    }

    public function index()
    {
        return Pizza::get();
    }

    public function show(Pizza $pizza)
    {
        return $pizza->load('ingredients');
    }

    public function destroy(Pizza $pizza) {
        $pizza->delete();
    }
}
