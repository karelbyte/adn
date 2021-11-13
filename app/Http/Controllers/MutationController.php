<?php

namespace App\Http\Controllers;

use App\Models\Mutation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Models\Sequencer;
use Exception;

class MutationController extends Controller
{
    public function addSecuence(StoreRequest $request)
    {
        try {
            if (!$request->has('dna')) {
                return response()->json('The DNA field was not found!');
            }
    
            $sequencer = new Sequencer($request->dna);

            if ($sequencer->hasDnaSecuencesError()) {
                return response()->json('The DNA is broken :(');
            }

            if ($sequencer->hasMutation()) {
                return response()->json(null, 200);
            };

            return response()->json(null, 403);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function getStats()
    {
        try {

            return response()->json(Mutation::getStats());

        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
