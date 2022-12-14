<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientPizza extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pizza_id' => ['required', 'integer', 'exists:pizzas,id'],
            'ingredient_id' => ['required', 'integer', 'exists:ingredients,id'],
            'order' => ['required', 'integer'],
        ];
    }
}
