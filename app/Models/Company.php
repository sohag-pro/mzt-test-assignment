<?php

namespace App\Models;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model {
    use HasFactory;

    /**
     * Relation with wallet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet() {
        return $this->hasOne( Wallet::class );
    }
}
