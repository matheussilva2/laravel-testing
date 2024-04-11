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
    private User $admin;

    protected function setUp():void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(true);
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

    public function test_admin_can_see_products_create_button()
    {
        $response = $this->actingAs($this->admin)->get("/products");

        $response->assertStatus(200);
        $response->assertSee("Add new product");
    }

    public function test_non_admin_cannot_see_products_create_button()
    {
        $response = $this->actingAs($this->user)->get("/products");

        $response->assertStatus(200);
        $response->assertDontSee("Add new product");
    }

    public function test_admin_can_access_products_create_page()
    {
        $response = $this->actingAs($this->admin)->get("/products/create");

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_products_create_page()
    {
        $response = $this->actingAs($this->user)->get("/products/create");

        $response->assertStatus(403);
    }

    public function test_non_authenticated_user_cannot_access_products_create_page()
    {
        $response = $this->get("/products/create");

        $response->assertStatus(302);
        $response->assertRedirect("login");
    }

    public function test_create_product_successful()
    {
        $product = [
            "name" => "Product 123",
            "price" => 1234
        ];

        $response = $this->actingAs($this->admin)->post('/products', $product);

        $response->assertStatus(302);
        $response->assertRedirect("products");

        $this->assertDatabaseHas("products", $product);
        $lastProduct = Product::latest()->first();
        $this->assertEquals($lastProduct->name, $product["name"]);
        $this->assertEquals($lastProduct->price, $product["price"]);
    }

    public function test_product_edit_contains_correct_values()
    {
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get("products/".$product->id."/edit");

        $response->assertStatus(200);
        $response->assertSee('value="'. $product->name .'"', false);
        $response->assertSee('value="'. $product->price .'"', false);
        $response->assertViewHas('product', $product);
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create(["is_admin" => $isAdmin]);
    }
}
