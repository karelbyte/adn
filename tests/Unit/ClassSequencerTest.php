<?php

namespace Tests\Unit;

use App\Models\Sequencer;
use PHPUnit\Framework\TestCase;

class ClassSequencerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_class_sequencer()
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

        $sequencer = new Sequencer($data);

        $this->assertTrue($sequencer);
    }
}
