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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_basic_request()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_api_version_route()
    {
        $versionPrefix = config('twill.api.version');

        $response = $this->get("/api/$versionPrefix");

        $response->assertJson([ 'data' => [] ]);

        $response->assertStatus(200);
    }

    public function test_module_api_blocks_list_exists()
    {
        $versionPrefix = config('twill.api.version');

        $response = $this->get("/api/$versionPrefix/blocks");

        $response->assertStatus(200);
    }

    public function test_module_api_books_list_exists()
    {
        $versionPrefix = config('twill.api.version');

        $response = $this->get("/api/$versionPrefix/books");

        $response->assertStatus(200);
    }
}
