<?php

namespace App\Http\Controllers;

use App\Services\AnalyseService;
use Illuminate\Http\Request;

class PhraseAnalyserController extends Controller
{
    Protected $analyseService;

    public function __construct(AnalyseService $analyseService)
    {
        $this->analyseService = $analyseService;
    }

    public function analyse(Request $request){

        trim($request->string);
        $request = $request->validate([
            'string' => 'required|max:255',
        ]);
        $response = $this->analyseService->analyse($request);
        return response()->json($response,200);
    }
}
