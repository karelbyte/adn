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
        $countMutations = self::where('sequence->countMutation', '>', 0)->get()->count();
        $countNoMutations =  self::where('sequence->countMutation', 0)->get()->count();
        $ratio = $countNoMutations == 0 ? 'no ratio' : (float) number_format($countMutations / $countNoMutations, 2, '.', '');
        return [
            "count_mutations" => $countMutations,
            "count_no_mutation" => $countNoMutations,
            "ratio" => $ratio
        ];
    }
}
