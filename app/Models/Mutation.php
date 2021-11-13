<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence'
    ];

    protected $casts = [
        'sequence' => 'array'
    ];

    public static function getStats()
    {
        $sequences = self::where('sequence->has_mutation', true)->get();
        $countMutations = self::where('sequence->has_mutation', true)->get()->count();
        $countNoMutations =  self::where('sequence->has_mutation', false)->get()->count();
        return [
            "count_mutations" => $countMutations,
            "count_no_mutation" => $countNoMutations,
            "ratio" => (double) number_format($countMutations / $countNoMutations, 1)
        ];
    }
}
