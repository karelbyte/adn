<?php

namespace App\Dna;

use App\Models\Mutation;
use Exception;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Collection;

class Sequencer
{
   
    protected $data;


    public function __construct($dna)
    {
         $this->data['dna'] = $dna;
    }

   
    public function checkDnaSecuencesError()
    {
        if (count($this->data['dna']) < 4) {
            throw new Exception('The DNA is broken, n < 4');
        }

        $broke = collect($this->data['dna'])->contains(function ($sequence) {
            return strlen($sequence) < 4;
        });

        if ($broke) {
            throw new Exception('The DNA is broken, sequence < 4');
        }

    }


   
    public function hasMutation(): bool
    {

       
        return app(Pipeline::class)
            ->send($this->data)
            ->through([
                StructureDna::class,
                CheckLinealMutation::class,
                CheckObliqueMutation::class,
                DnaStore::class
            ])
            ->then(function ($data) {
                return $data['countMutation'];
            });
    }

}
