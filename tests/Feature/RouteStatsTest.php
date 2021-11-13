<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteStatsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_stats()
    {

        $response = $this->get('api/stats');

        $response->assertStatus(200);
  
    }
}
