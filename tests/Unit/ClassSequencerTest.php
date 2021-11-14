<?php

namespace Tests\Unit;

use App\Models\Sequencer;
use Tests\TestCase;

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
    
                "CGAGAG",
                "CATCDC",
                "TACTCT",
                "ATCGGA",
                "TGCTGT",
                "TGCTGT"
        
          ];

        $sequencer = new Sequencer($data);

    
        $this->assertTrue(is_bool($sequencer->hasDnaSecuencesError()));

        $this->assertTrue(is_array($sequencer->rotateDna($data, 1)));

        $this->assertTrue(is_bool($sequencer->hasMutation()));
    }
}
