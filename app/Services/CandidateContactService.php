<?php
namespace App\Services;

use App\Models\Wallet;
use App\Models\Company;
use App\Models\Candidate;
use App\Mail\CandidateContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CandidateContactService {

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
    private $chargeCoinForContact;

    /**
     * @param $candidateId
     * @param $companyId
     */
    public function __construct( $candidateId, $companyId ) {
        $this->candidate = Candidate::find( $candidateId );
        $this->company   = Company::find( $companyId );

        $this->chargeCoinForContact = config( 'company.charge_coin_for_contact' );

        if ( !$this->candidate || !$this->company ) {
            throw new \Exception( 'Candidate or company not found.' );
        }
    }

    /**
     * Contact a candidate.
     */
    public function contact(): array{

        if ( $this->candidate->isContacted( $this->company->id ) ) {
            return [
                'success' => false,
                'message' => 'You have already contacted this candidate.',
            ];
        }

        if ( !$this->_hasChargedCoinFromBalance() ) {
            return [
                'success' => false,
                'message' => 'Insufficient coin balance',
            ];
        }

        $this->_sendContactEmail();

        $this->_addContactToCandidate();

        return [
            'success' => true,
            'message' => 'Contacted candidate successfully.',
        ];
    }

    private function _hasChargedCoinFromBalance(): bool {
        DB::beginTransaction();

        $wallet = Wallet::lockForUpdate()->find( $this->company->wallet->id );

        if ( $wallet->coins < $this->chargeCoinForContact ) {
            DB::rollBack();
            return false;
        }

        $wallet->coins -= $this->chargeCoinForContact;
        $wallet->save();

        DB::commit();

        return true;
    }

    private function _sendContactEmail(): void {
        Mail::to( $this->candidate )->queue( new CandidateContact( $this->company ) );
    }

    private function _addContactToCandidate(): void {
        $this->candidate->contacts()->firstOrCreate( [
            'company_id' => $this->company->id,
        ] );
    }
}