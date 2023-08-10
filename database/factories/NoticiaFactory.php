<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userId = 0;

        // Incrementar el número de usuario en cada llamada al Factory
        $userId++;

        return [
            'usuarios_id' => $userId,
            'contenido' => fake()->paragraph(),
            'post_anonimo' => fake()->boolean(),
        ];
    }
}
