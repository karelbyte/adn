<?php

namespace App\Dna;

use Closure;
use App\Models\Mutation;
use Illuminate\Support\Arr;

class DnaStore
{
    
    public function handle($data, Closure $next)
    {
        Mutation::create([
            'sequence' => Arr::only($data, ['dna', 'countMutation'])
        ]);

        return $next($data);

    }
}
