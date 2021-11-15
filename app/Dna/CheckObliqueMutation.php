<?php

namespace App\Dna;

use Closure;

class CheckObliqueMutation
{
    use RotateDna;

    public function handle($data, Closure $next)
    {

        $countMutation = $data['countMutation'];

        for ($rotate = 0; $rotate < 2; $rotate++) {
            $matrix = $this->rotate($data['matrix'], $rotate, $data['dnaLength']);
            for ($i = 0; $i < $data['dnaLength']; $i++) {
                for ($j = 0; $j < $data['dnaLength']; $j++) {
                    if ($i + 3 <$data['dnaLength'] && $j + 3 < $data['dnaLength']) {
                        $segmentOne  = $matrix[$i][$j] == $matrix[$i + 1][$j + 1];
                        $segmentTwo  = $matrix[$i + 2][$j + 2] == $matrix[$i + 3][$j + 3];
                        $corners = $matrix[$i][$j] == $matrix[$i + 3][$j + 3];
                        $mutationFound = $corners && $segmentOne && $segmentTwo;
                        if ($mutationFound) {
                            $j = $j + 4;
                            $i = $i + 4;
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
