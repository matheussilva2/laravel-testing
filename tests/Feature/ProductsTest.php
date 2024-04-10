<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_pages_contains_empty_table()
    {
        $response = $this->get("/products");
        
        $response->assertSee("No products found");
        $response->assertStatus(200);
    }

    public function test_products_pages_non_empty_table()
    {
        $product = Product::create([
            "name" => "Product 1",
            "price" => "123"
        ]);

        $response = $this->get("/products");
        
        $response->assertStatus(200);
        $response->assertDontSee("No products found");
        $response->assertViewHas("products", function($collection) use($product){
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        for ($i=0; $i <= 11; $i++) { 
            $newProduct = [
                "name" => generateRandomString(20),
                "price" => rand(100, 999)
            ];

            Product::create($newProduct);
        }

        $products = Product::all();
        $lastProduct = $products->last();

        $response = $this->get("/products");
        $response->assertStatus(200);
        $response->assertViewHas("products", function($collection) use ($lastProduct){
            return !$collection->contains($lastProduct);
        });
    }
}
