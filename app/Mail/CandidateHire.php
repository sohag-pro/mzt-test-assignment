<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateHire extends Mailable {
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Company
     */
    private $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $company ) {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->text( 'emails.hire', ['company' => $this->company] );
    }
}
