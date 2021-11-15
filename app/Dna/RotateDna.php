<?php

namespace App\Dna;

trait RotateDna
{

    public function rotate($matrix, $rotate, $n): array
    {
        $ret = $matrix;
        if ($rotate != 0) {
            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $ret[$i][$j] = $matrix[$n - $j - 1][$i];
                }
            }
            $this->rotate($ret, $rotate - 1, $n);
        }
        return $ret;
    }

}