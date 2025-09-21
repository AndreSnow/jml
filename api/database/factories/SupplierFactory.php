<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition()
    {
        $validCnpjs = [
            '12345678000195',
            '04252011000110',
            '11444777000161',
            '27865757000102',
            '19131243000197'
        ];
        static $i = 0;
        return [
            'name' => $this->faker->company,
            'cnpj' => $validCnpjs[$i++ % count($validCnpjs)],
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}