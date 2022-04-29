<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateHireTest extends TestCase
{
    /**
     * Try Hire without contact
     *
     * @return void
     */
    public function test_without_contact_hire_should_be_failed()
    {
        Artisan::call('migrate:fresh --seed');
        $response = $this->post('/candidates-hire', [
            'candidate_id' => 1
        ]);

        $this->assertFalse($response->json('success'));
    }

    /**
     * Try Hire without contact
     *
     * @return void
     */
    public function test_contact_then_hire()
    {
        $response = $this->post('/candidates-contact', [
            'candidate_id' => 1
        ]);
        $response = $this->post('/candidates-hire', [
            'candidate_id' => 1
        ]);

        $this->assertTrue($response->json('success'));
    }

    /**
     * check if coin balance is 20
     *
     * @return void
     */
    public function test_after_hire_coins_sholud_be_more() {
        $response = $this->get( '/candidates-list' );
        $response->assertSee('Your wallet has: 20 coins');
    }

    /**
     * Try Hire without contact
     *
     * @return void
     */
    public function test_hire_twice_should_be_failed()
    {
        $response = $this->post('/candidates-contact', [
            'candidate_id' => 2
        ]);
        $response = $this->post('/candidates-hire', [
            'candidate_id' => 2
        ]);

        $response = $this->post('/candidates-hire', [
            'candidate_id' => 2
        ]);

        $this->assertFalse($response->json('success'));
    }


}
