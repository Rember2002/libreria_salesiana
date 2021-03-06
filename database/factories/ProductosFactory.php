<?php

namespace Database\Factories;

use App\Models\Productos;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Productos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_producto' => $this->faker->name(),
            'marca_producto' => $this->faker->name(),
            'descripcion_producto' => $this->faker->paragraph(),
            'precio_producto' => $this->faker->numberBetween(1,9999),
            
        ];
    }
}
