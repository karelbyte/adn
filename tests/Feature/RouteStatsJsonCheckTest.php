<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteStatsJsonCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_stats_json_check()
    {

        $this->json('GET', 'api/stats')
            ->assertJson([
            "count_mutations" => true,
            "count_no_mutation" => true,
            "ratio" => true
        ]);
    }
}
