<?php

namespace App\Http\Controllers;

use App\Models\Mutation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Dna\Sequencer;
use Exception;

class MutationController extends Controller
{
    public function addSecuence(StoreRequest $request)
    {
         try {
    
            $sequencer = new Sequencer($request->dna);

            $sequencer->checkDnaSecuencesError();

            $codeResponse = $sequencer->hasMutation() ? 200 : 403;

            return response()->json(null, $codeResponse);

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
