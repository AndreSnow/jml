<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition()
    {
        // Gera CNPJs únicos e válidos
        static $used = [];
        do {
            $cnpj = $this->faker->unique()->numerify('########0001##');
        } while (in_array($cnpj, $used));
        $used[] = $cnpj;

        return [
            'name' => $this->faker->company,
            'cnpj' => $cnpj,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
