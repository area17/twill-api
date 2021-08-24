<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_a_basic_request()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_module_api_blocks_list_exists()
    {
        $response = $this->get("/api/v1/blocks");

        $response->assertStatus(200);
    }

    public function test_module_api_books_list_exists()
    {
        $response = $this->get("/api/v1/books");

        $response->assertStatus(200);
    }

    public function test_module_api_authors_list_exists()
    {
        $response = $this->get("/api/v1/authors");

        $response->assertStatus(200);
    }
}
