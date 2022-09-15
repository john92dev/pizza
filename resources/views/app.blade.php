<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pizzas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

</head>
<body>

<div class="mx-4" id="app">
    <div class="row my-4">
        <div class="col-6">
            <div class="input-group mb-3">
                <input v-model="new_pizza" type="text" class="form-control">
                <button
                    @click.prevent="createPizza"
                    class="btn btn-primary" type="button">Create Pizza
                </button>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-5">
            <div class="input-group mb-3">
                <select class="form-select" v-model="new_recipe_ingredient.ingredient_id">
                    <option v-for="(ingredient, key) in ingredients" :value="ingredient.id" :key="key">
                        @{{ ingredient.name }}
                    </option>
                </select>
                <input v-model="new_recipe_ingredient.order" placeholder="Order" type="text" class="form-control">
                <button
                    @click.prevent="addIngredientToSelectedPizza"
                    class="btn btn-primary" type="button">Add to Recipe
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h4>Select Pizza:</h4>
            <table class="table table-primary">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(pizza, key) in pizzas" :key="key">
                    <th scope="row">@{{key + 1}}</th>
                    <td class="cursor-pointer"
                        @click="selectPizza(pizza.id)">
                        <input v-model="pizza.name" type="text" class="form-control">
                    </td>
                    <td>@{{ pizza.selling_price / 100 }} EUR</td>
                    <td>
                        <a href="#"
                           @click.prevent="editPizza(pizza)"
                           class="btn btn-warning btn-sm mx-2">Edit</a>
                        <a href="#"
                           @click.prevent="deletePizza(pizza.id)"
                           class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-1"></div>
        <div class="col-5">
            <div v-if="selected_pizza">
                <h4>@{{ selected_pizza.name }} consists from:</h4>
                <table class="table table-primary">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Cost Price</th>
                        <th scope="col">Order</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(ingredient, key) in selected_pizza.ingredients" :key="key">
                        <th scope="row">@{{ key + 1 }}</th>
                        <td>@{{ ingredient.name }}</td>
                        <td>@{{ ingredient.cost_price / 100 }} EUR</td>
                        <td><input v-model="ingredient.pivot.order"
                                   type="text" class="form-control"></td>
                        <td>
                            <a href="#"
                               @click.prevent="editIngredientFromRecipe(ingredient)"
                               class="btn btn-warning btn-sm mx-2">Edit</a>
                            <a href="#"
                               @click.prevent="deleteIngredientFromRecipe(ingredient.pivot.id)"
                               class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-6">
            <div class="input-group mb-3">
                <input v-model="new_ingredient.name" type="text" placeholder="Ing name" class="form-control">
                <input v-model="new_ingredient.cost_price" type="text" placeholder="Ing cost price in cents"
                       class="form-control">
                <button
                    @click.prevent="createIngredient"
                    class="btn btn-primary" type="button">Create Ingredient
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-6">
            <h4>All Ingredients</h4>
            <table class="table table-primary">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Cost Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(ingredient, key) in ingredients" :key="key">
                    <th scope="row">@{{key + 1}}</th>
                    <td><input v-model="ingredient.name"
                               type="text" class="form-control"></td>
                    <td><input v-model="ingredient.cost_price"
                               placeholder="Euro Cents"
                               type="text" class="form-control"></td>
                    <td>
                        <a href="#"
                           @click.prevent="editIngredient(ingredient)"
                           class="btn btn-warning btn-sm mx-2">Edit</a>
                        <a href="#"
                           @click.prevent="deleteIngredient(ingredient.id)"
                           class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const {createApp} = Vue

    createApp({
        created() {
            this.loadPizzas();

            axios.get('/api/ingredients').then(r => {
                this.ingredients = r.data;
            });
        },

        data() {
            return {
                new_pizza: '',
                new_ingredient: {
                    name: '',
                    cost_price: 0,
                },
                new_recipe_ingredient: {
                    pizza_id: 0,
                    ingredient_id: 0,
                    order: 0,
                },
                pizzas: [],
                ingredients: [],
                selected_pizza: null,
            }
        },

        methods: {
            loadPizzas() {
                axios.get('/api/pizzas').then(r => {
                    this.pizzas = r.data;
                });
            },

            selectPizza(pizza_id) {
                axios.get('/api/pizzas/' + pizza_id).then(r => {
                    this.selected_pizza = r.data;
                    this.pizzas.forEach((p, k) => {
                        if (p.id === pizza_id) {
                            this.pizzas[k] = {...r.data};
                        }
                    })
                });
            },

            deletePizza(pizza_id) {
                axios.delete('/api/pizzas/' + pizza_id);
                this.pizzas = this.pizzas.filter(p => p.id !== pizza_id);
            },

            deleteIngredient(ingredient_id) {
                axios.delete('/api/ingredients/' + ingredient_id).then((r) => {
                    this.loadPizzas();
                    this.selectPizza(this.selected_pizza.id);
                });
                this.ingredients = this.ingredients.filter(i => i.id !== ingredient_id);
            },

            deleteIngredientFromRecipe(ingredient_pizza_id) {
                axios.delete('/api/ingredient-pizza/' + ingredient_pizza_id).then(r => {
                    this.selectPizza(this.selected_pizza.id);
                });
            },

            createPizza() {
                axios.post('/api/pizzas', {
                    name: this.new_pizza,
                }).then(r => {
                    this.new_pizza = '';
                    r.data.selling_price = 0;
                    this.pizzas.push(r.data);
                });
            },

            createIngredient() {
                axios.post('/api/ingredients', this.new_ingredient).then(r => {
                    this.new_ingredient.name = '';
                    this.new_ingredient.cost_price = 0;
                    this.ingredients.push(r.data);
                });
            },


            addIngredientToSelectedPizza() {
                this.new_recipe_ingredient.pizza_id = this.selected_pizza.id;
                axios.post('/api/ingredient-pizza', this.new_recipe_ingredient).then(r => {
                    this.new_recipe_ingredient.ingredient_id = 0;
                    this.new_recipe_ingredient.order = 0;
                    this.selectPizza(r.data.pizza_id);
                });
            },

            editPizza(pizza) {
                axios.patch('/api/pizzas/' + pizza.id, pizza);
            },

            editIngredientFromRecipe(ingredient) {
                axios.patch('/api/ingredient-pizza/' + ingredient.pivot.id, {
                    order: ingredient.pivot.order,
                }).then(r => {
                    this.selectPizza(this.selected_pizza.id);
                });
            },

            editIngredient(ingredient) {
                axios.patch('/api/ingredients/' + ingredient.id, ingredient).then((r) => {
                    this.loadPizzas();
                    this.selectPizza(this.selected_pizza.id);
                });
            }
        }
    }).mount('#app')
</script>

</body>
</html>
