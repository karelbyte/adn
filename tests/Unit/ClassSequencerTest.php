<?php

namespace Tests\Unit;

use App\Dna\Sequencer;
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

    
       // $this->assertTrue(is_bool($sequencer->checkDnaSecuencesError()));

        $this->assertTrue(is_bool($sequencer->hasMutation()));
    }
}
