<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteMutationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_mutation()
    {

        $data = [
          "dna" => [
              "AGAGAG",
              "CATCDC",
              "TATTGT",
              "ATTGGA",
              "TGTTGT"
          ]
        ];

        $response = $this->post('api/mutation', $data);

        $response->assertStatus(200);
    }
}
