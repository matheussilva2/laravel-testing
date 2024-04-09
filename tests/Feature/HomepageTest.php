<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_homepage_return_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_homepage_contains_documentation()
    {
        $response = $this->get("/");

        $response->assertSee("Documentation");
        $response->assertStatus(200);
    }

    public function test_homepage_contains_laracasts()
    {
        $response = $this->get("/");

        $response->assertSee("Laracasts");
        $response->assertStatus(200);
    }

    public function test_homepage_contains_laravel_news()
    {
        $response = $this->get("/");
        $response->assertSee("Laravel News");
        $response->assertStatus(200);
    }

    public function test_the_homepage_contains_vibrant_ecosystem()
    {
        $response = $this->get("/");
        $response->assertSee("Vibrant Ecosystem");
        $response->assertStatus(200);
    }
}
