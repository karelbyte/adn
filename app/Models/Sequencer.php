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

    protected function structureMatrix()
    {
        $this->n = strlen($this->dna[0]);

        for ($i=0; $i < $this->n; $i++) {
            for ($j=0; $j < $this->n; $j++) {
                $this->matrix[$i][$j] = substr($this->dna[$i], $j, 1);
            }
        }
    }

    public function rotateMatrix($matrix, $rotate)
    {
        if ($rotate != 0) {
            for ($i = 0; $i < $this->n; $i++) {
                for ($j = 0; $j < $this->n; $j++) {
                    $matrix[$i][$j] = $matrix[$this->n - $j - 1][$i];
                }
            }
            echo $rotate;
            $this->rotateMatrix($matrix, $rotate - 1);
        } else {
            dd($matrix);
        }
    }

    public function checkLineal()
    {
        $hasMutation = false;
        $matrix = $this->matrix;
        for ($i=0; $i < $this->n; $i++) {
            for ($j=0; $j < $this->n; $j++) {
                if ($j + 3 < $this->n) {
                    $segmentOne  = $matrix[$i][$j] == $matrix[$i][$j + 1];
                    $segmentTwo  = $matrix[$i][$j + 2] == $matrix[$i][$j + 3];
                    $corners = $matrix[$i][$j] == $matrix[$i][$j + 3];
                    $hasMutation = $corners &&  $segmentOne && $segmentTwo;
                    if ($hasMutation) {
                        // dd($matrix[$i][$j], $matrix[$i][$j + 1], $matrix[$i][$j] == $matrix[$i][$j + 1]);
                        echo $matrix[$i][$j] . $matrix[$i][$j + 1] . $matrix[$i][$j + 2] . $matrix[$i][$j + 3] ."<br>" ;
                    }
                }
            }
        }
        return $hasMutation;
    }

    public function checkOblique()
    {
        $matrix = $this->matrix;
        $hasMutation = false;
        for ($i=0; $i < $this->n; $i++) {
            for ($j=0; $j < $this->n; $j++) {
                if ($i + 3 < $this->n && $j + 3 < $this->n) {
                    $segmentOne  = $matrix[$i][$j] == $matrix[$i + 1][$j + 1];
                    $segmentTwo  = $matrix[$i + 2][$j + 2] == $matrix[$i + 3][$j + 3];
                    $corners = $matrix[$i][$j] == $matrix[$i + 3][$j + 3];
                    $hasMutation = $corners &&  $segmentOne && $segmentTwo;
                    if ($hasMutation) {
                        // dd($matrix[$i][$j], $matrix[$i][$j + 1], $matrix[$i][$j] == $matrix[$i][$j + 1]);
                        echo $matrix[$i][$j] . $matrix[$i + 1][$j + 1] . $matrix[$i + 2][$j + 2] . $matrix[$i + 3][$j+ 3] ."<br>" ;
                    }
                }
            }
        }
        return $hasMutation;
    }

    public function check(): bool
    {

        $this->structureMatrix();

        $this->checkLineal();
        
        $this->rotateMatrix($this->matrix, 3);

        $this->checkLineal();

        // $this->checkOblique();
        // $this->rotateMatrix();
        // $this->rotateMatrix();
        // $this->rotateMatrix();
        // $this->checkOblique();

        return true;
    }


    public function save()
    {
         $this->getDna()->each(function ($sequence) {
            Mutation::create([
               'sequence' => $sequence
            ]);
         });

        return $this;
    }


    /*int[,] array = new int[4,4] {
    { 1,2,3,4 },
    { 5,6,7,8 },
    { 9,0,1,2 },
    { 3,4,5,6 }
};

int[,] rotated = RotateMatrix(array, 4);

static int[,] RotateMatrix(int[,] matrix, int n) {
    int[,] ret = new int[n, n];

    for (int i = 0; i < n; ++i) {
        for (int j = 0; j < n; ++j) {
            ret[i, j] = matrix[n - j - 1, i];
        }
    }

    return ret;
}*/
}
