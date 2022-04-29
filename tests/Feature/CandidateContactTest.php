<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Wallet;
use Illuminate\Support\Facades\Artisan;

class CandidateContactTest extends TestCase {
    /**
     * Contact a candidate.
     *
     * @return void
     */
    public function test_contact_candidate() {
        Artisan::call( 'migrate:fresh --seed' );
        $response = $this->post( '/candidates-contact', [
            'candidate_id' => 1,
        ] );

        $this->assertTrue( $response->json( 'success' ) );
    }

    /**
     * Contact a candidate twice should fail.
     *
     * @return void
     */
    public function test_contact_candidate_twice_should_be_failed() {
        $response = $this->post( '/candidates-contact', [
            'candidate_id' => 2,
        ] );

        $response = $this->post( '/candidates-contact', [
            'candidate_id' => 2,
        ] );

        $this->assertFalse( $response->json( 'success' ) );
    }

    /**
     * check if coin balance is 10
     *
     * @return void
     */
    public function test_after_contact_coins_sholud_be_less() {
        $response = $this->get( '/candidates-list' );
        $response->assertSee('Your wallet has: 10 coins');
    }

    /**
     * Contact a candidate twice should fail.
     *
     * @return void
     */
    public function test_contact_candidate_without_enough_token_should_be_failed() {
        Wallet::where( 'company_id', 1 )->update( ['coins' => 0] );

        $response = $this->post( '/candidates-contact', [
            'candidate_id' => 3,
        ] );

        $this->assertFalse( $response->json( 'success' ) );
    }

}
