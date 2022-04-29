<?php

namespace App\Models;

use App\Models\CandidateContact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model {
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts() {
        return $this->hasMany( CandidateContact::class );
    }

    /**
     * Check if the candidate is contacted by the company
     *
     * @param  $companyId
     * @return bool
     */
    public function isContacted( $companyId ) {
        return $this->contacts()->where( 'company_id', $companyId )->exists();
    }
}
