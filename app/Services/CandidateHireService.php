<?php
namespace App\Services;

use App\Models\Wallet;
use App\Models\Company;
use App\Models\Candidate;
use App\Mail\CandidateHire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CandidateHireService {
    /**
     * @var \App\Models\Candidate
     */
    private $candidate;

    /**
     * @var \App\Models\Company
     */
    private $company;

    /**
     * @var integer
     */
    private $putBackCoinForHire;

    /**
     * @param $candidateId
     * @param $companyId
     */
    public function __construct( $candidateId, $companyId ) {
        $this->candidate = Candidate::find( $candidateId );
        $this->company   = Company::find( $companyId );

        $this->putBackCoinForHire = config( 'company.put_back_coin_for_hire' );

        if ( !$this->candidate || !$this->company ) {
            throw new \Exception( 'Candidate or company not found.' );
        }
    }

    public function hire() {
        if ( !$this->candidate->isContacted( $this->company->id ) ) {
            return [
                'success' => false,
                'message' => 'You have not contacted this candidate. Please contact first.',
            ];
        }

        if ( $this->candidate->isHired( $this->company->id ) ) {
            return [
                'success' => false,
                'message' => 'You have already hired this candidate.',
            ];
        }

        if ( !$this->_hasRefundedCoinToBalance() ) {
            return [
                'success' => false,
                'message' => 'Coin refund failed. Please try again later.',
            ];
        }

        $this->_sendHireEmail();
        $this->candidate->hire( $this->company->id );

        return [
            'success' => true,
            'message' => 'Hired candidate successfully.',
        ];

    }

    private function _hasRefundedCoinToBalance(): bool {

        try {
            DB::beginTransaction();
            $wallet = Wallet::lockForUpdate()->find( $this->company->wallet->id );
            $wallet->coins += $this->putBackCoinForHire;
            $wallet->save();
            DB::commit();
        } catch ( \Throwable$th ) {
            info( $th->getMessage() );
            DB::rollBack();
            return false;
        }

        return true;
    }

    private function _sendHireEmail() {
        Mail::to( $this->candidate )->queue( new CandidateHire( $this->company ) );
    }

}