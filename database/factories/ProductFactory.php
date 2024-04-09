<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class ProductFactory extends Factory
{
    use WithFaker;
    
    public function __construct()
    {
        $this->setUpFaker();
    }

    public function definition()
    {
        return [
            "name" => $this->faker()->text(20),
            "price" => rand(100, 999)
        ];
    }
}
