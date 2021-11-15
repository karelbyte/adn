<?php

namespace App\Dna;

use Closure;

class CheckLinealMutation
{
    use RotateDna;

    public function handle($data, Closure $next)
    {

        $countMutation = 0;
        for ($rotate = 0; $rotate < 2; $rotate++) {
            $matrix = $this->rotate($data['matrix'], $rotate, $data['dnaLength']);
            for ($i = 0; $i < $data['dnaLength']; $i++) {
                for ($j = 0; $j < $data['dnaLength']; $j++) {
                    if ($j + 3 < $data['dnaLength']) {
                        $segmentOne  = $matrix[$i][$j] == $matrix[$i][$j + 1];
                        $segmentTwo  = $matrix[$i][$j + 2] == $matrix[$i][$j + 3];
                        $corners = $matrix[$i][$j] == $matrix[$i][$j + 3];
                        $mutationFound = $corners && $segmentOne && $segmentTwo;
                        if ($mutationFound) {
                            $j = $j + 4;
                            $countMutation++;
                        }
                    }
                }
            }
        }

        $data['countMutation'] = $countMutation;

        return $next($data);
    }
}
