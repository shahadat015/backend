<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'price' => $this->faker->randomNumber(3),
            'description' => $this->faker->text,
            'image' => $this->faker->randomElement(['products/cap.png','products/bag.png','products/shoe.png', 'products/sunglass.png', 'products/watch.png']),
        ];
    }
}
