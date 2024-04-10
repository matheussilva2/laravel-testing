<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp():void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    private function createUser()
    {
        return User::factory()->create();
    }

    public function test_products_pages_contains_empty_table()
    {
        $response = $this->actingAs($this->user)->get("/products");
        
        $response->assertSee("No products found");
        $response->assertStatus(200);
    }

    public function test_products_pages_non_empty_table()
    {
        $product = Product::create([
            "name" => "Product 1",
            "price" => "123"
        ]);

        $response = $this->actingAs($this->user)->get("/products");
        
        $response->assertStatus(200);
        $response->assertDontSee("No products found");
        $response->assertViewHas("products", function($collection) use($product){
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($this->user)->get("/products");
        $response->assertStatus(200);
        $response->assertViewHas("products", function($collection) use ($lastProduct){
            return !$collection->contains($lastProduct);
        });
    }
}
