<?php

namespace App\Models;

use App\Models\Mutation;
use Illuminate\Support\Collection;

class Sequencer
{
   
    protected $dna;

    protected $n;

    protected $matrix;

    public function __construct($dna)
    {
         $this->dna = $dna;
    }

    public function getDna(): Collection
    {
        return collect($this->dna);
    }

    public function hasDnaSecuencesError(): bool
    {
        if ($this->getDna()->count() < 4) {
            return true;
        }

        $broke = $this->getDna()->contains(function ($sequence) {
            return strlen($sequence) < 4;
        });

        return $broke;
    }

    protected function structureDna()
    {
        $this->n = $this->getDna()->count();

        for ($i=0; $i < $this->n; $i++) {
            for ($j=0; $j < $this->n; $j++) {
                $this->matrix[$i][$j] = substr($this->dna[$i], $j, 1);
            }
        }
    }

    public function rotateDna($matrix, $rotate)
    {
        $ret = $matrix;
        if ($rotate != 0) {
            for ($i = 0; $i < $this->n; $i++) {
                for ($j = 0; $j < $this->n; $j++) {
                    $ret[$i][$j] = $matrix[$this->n - $j - 1][$i];
                }
            }
            $this->rotateDna($ret, $rotate - 1);
        }
        return $ret;
    }

    

    protected function seeker($matrix, $i, $j)
    {
        $segmentOne  = $matrix[$i][$j] == $matrix[$i][$j + 1];
        $segmentTwo  = $matrix[$i][$j + 2] == $matrix[$i][$j + 3];
        $corners = $matrix[$i][$j] == $matrix[$i][$j + 3];
        return $corners && $segmentOne && $segmentTwo;
    }

    protected function seekerOblique($matrix, $i, $j)
    {
        $segmentOne  = $matrix[$i][$j] == $matrix[$i + 1][$j + 1];
        $segmentTwo  = $matrix[$i + 2][$j + 2] == $matrix[$i + 3][$j + 3];
        $corners = $matrix[$i][$j] == $matrix[$i + 3][$j + 3];
        return $corners && $segmentOne && $segmentTwo;
    }


    protected function runer($direction, $i, $matrix, $foundMutation)
    {
        for ($j=0; $j < $this->n; $j++) {
            if ($direction == 'oblique' && $i + 3 < $this->n && $j + 3 < $this->n) {
                if ($this->seekerOblique($matrix, $i, $j)) {
                    $j = $j + 4;
                    $i = $i + 4;
                    $foundMutation++;
                }
            }

            if ($direction == 'lineal' && $j + 3 < $this->n) {
                if ($this->seeker($matrix, $i, $j)) {
                    $j = $j + 4;
                    $foundMutation++;
                }
            }
        }

        return $foundMutation;
    }

    public function check($direction = 'lineal')
    {
        $matrix = $this->matrix;
        $foundMutation = 0;
        for ($rotate = 0; $rotate < 2; $rotate++) {
            $matrix = $this->rotateDna($matrix, $rotate);
            for ($i=0; $i < $this->n; $i++) {
                $foundMutation += $this->runer($direction, $i, $matrix, $foundMutation);
            }
        }
        return $foundMutation > 1;
    }

    

    public function hasMutation(): bool
    {

        $this->structureDna();
        
        $has = $this->check() || $this->check('oblique');

        $this->save($has);

        return $has;
    }


    public function save($has)
    {
        Mutation::create([
            'sequence' => [
                'dna' => $this->dna,
                'secuences' => count($this->dna),
                'has_mutation' => $has
            ]
         ]);
    }
}
