<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CandidateContact;
use App\Services\CandidateHireService;
use App\Services\CandidateContactService;
use App\Http\Requests\CandidateHireRequest;
use App\Http\Requests\CandidateContactRequest;

class CandidateController extends Controller {

    /**
     * Display a listing of the candidates.
     */
    public function index() {
        $candidates = Candidate::all();
        $coins      = Company::find( 1 )->wallet->coins;
        $hires      = CandidateContact::where( 'company_id', 1 )
            ->where( 'is_hired', true )
            ->get( ['candidate_id'] )
            ->pluck( ['candidate_id'] )
            ->toArray();
        return view( 'candidates.index', compact( 'candidates', 'coins', 'hires' ) );
    }

    /**
     * Contact a candidate.
     *
     * @param  Request    $request
     * @return Response
     */
    public function contact( CandidateContactRequest $request ) {
        $candidateId = $request->input( 'candidate_id' );
        try {
            return response()->json(  ( new CandidateContactService( $candidateId, 1 ) )->contact() );
        } catch ( \Throwable$th ) {
            info( $th->getMessage() );
            return [
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ];
        }
    }

    /**
     * Hire a candidate.
     *
     * @param Request $request
     * @return Response
     */
    public function hire( CandidateHireRequest $request ) {
        $candidateId = $request->input( 'candidate_id' );
        try {
            return response()->json(  ( new CandidateHireService( $candidateId, 1 ) )->hire() );
        } catch ( \Throwable$th ) {
            info( $th->getMessage() );
            return [
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ];
        }
    }
}
