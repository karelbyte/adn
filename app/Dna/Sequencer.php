<?php

namespace App\Dna;

use App\Models\Mutation;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Collection;

class Sequencer
{
   
    protected $data;


    public function __construct($dna)
    {
         $this->data['dna'] = $dna;
    }

   
    public function hasDnaSecuencesError(): bool
    {
        if (count($this->data['dna']) < 4) {
            return true;
        }

        $broke = collect($this->data['dna'])->contains(function ($sequence) {
            return strlen($sequence) < 4;
        });

        return $broke;
    }


   
    public function hasMutation()
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
