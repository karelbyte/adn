<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteNoMutationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_no_mutation()
    {

        $data = [
          "dna" => [
              "CGAGAG",
              "CATCDC",
              "TACTCT",
              "ATCGGA",
              "TGCTGT"
          ]
        ];

        $response = $this->post('api/mutation', $data);

        $response->assertStatus(403);
    }
}
