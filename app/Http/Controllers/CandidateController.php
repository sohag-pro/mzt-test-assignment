<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Candidate;

class CandidateController extends Controller {

    /**
     * Display a listing of the candidates.
     */
    public function index() {
        $candidates = Candidate::all();
        $coins      = Company::find( 1 )->wallet->coins;
        return view( 'candidates.index', compact( 'candidates', 'coins' ) );
    }

    public function contact() {
        // @todo
        // Your code goes here...
    }

    public function hire() {
        // @todo
        // Your code goes here...
    }
}
