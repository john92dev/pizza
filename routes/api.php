<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientPizzaController;

Route::post('pizzas', [PizzaController::class, 'store']);
Route::patch('pizzas/{pizza}', [PizzaController::class, 'update']);
Route::get('pizzas', [PizzaController::class, 'index']);
Route::get('pizzas/{pizza}', [PizzaController::class, 'show']);
Route::delete('pizzas/{pizza}', [PizzaController::class, 'destroy']);


Route::post('ingredients', [IngredientController::class, 'store']);
Route::patch('ingredients/{ingredient}', [IngredientController::class, 'update']);
Route::get('ingredients', [IngredientController::class, 'index']);
Route::get('ingredients/{ingredient}', [IngredientController::class, 'show']);
Route::delete('ingredients/{ingredient}', [IngredientController::class, 'destroy']);

Route::post('ingredient-pizza', [IngredientPizzaController::class, 'store']);
Route::patch('ingredient-pizza/{ingredientPizza}', [IngredientPizzaController::class, 'update']);
Route::delete('ingredient-pizza/{ingredientPizza}', [IngredientPizzaController::class, 'destroy']);
