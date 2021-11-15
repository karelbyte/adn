<?php

namespace App\Dna;

use Closure;

class StructureDna
{
    
    public function handle($data, Closure $next)
    {
        $dna = $data['dna'];
        $dnaLength = count($dna);

        for ($i=0; $i < $dnaLength; $i++) {
            for ($j=0; $j < $dnaLength; $j++) {
                $matrix[$i][$j] = substr($dna[$i], $j, 1);
            }
        }

        $data['matrix'] = $matrix;
        $data['dnaLength'] = $dnaLength;

        return $next($data);
    }
}
