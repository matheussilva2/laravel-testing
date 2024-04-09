<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class ProductSeed extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("products")->insert([
            "name" => $this->faker()->text(20),
            "price" => rand(100, 999)
        ]);
    }
}
