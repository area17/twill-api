<?php

namespace A17\Twill\API\Tests\Feature;

use A17\Twill\API\Tests\TestCase;

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
    public function test_api_version_route()
    {
        $versionPrefix = config('twill.api.version');

        $response = $this->get("/api/$versionPrefix");

        $response->assertJson([]);

        $response->assertStatus(200);
    }
}
