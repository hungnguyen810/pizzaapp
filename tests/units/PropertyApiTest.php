<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropertyApiTest extends ApiTestCase
{
    use WithoutMiddleware;

    public function test_required_params()
    {
        // No params
        $this->json('GET', '/api/v1/properties/', [])
            ->seeStatusCode(422);

        // Missing address
        $this->json('GET', '/api/v1/properties/', ['postcode' => '123'])
            ->seeStatusCode(422);

        // Missing postcode
        $this->json('GET', '/api/v1/properties/', ['address' => 'address'])
            ->seeStatusCode(422);
    }

    public function test_valid_params()
    {
        // Invalid UK postcode
        $this->json('GET', '/api/v1/properties/', ['postcode' => 123, 'address' => 'address'])
            ->seeStatusCode(422);

        // Correct params
        $this->json('GET', '/api/v1/properties/', ['postcode' => 'ME7 9AA', 'address' => 'address'])
            ->seeStatusCode(200);
    }

}
