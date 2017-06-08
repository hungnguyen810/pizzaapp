<?php

use App\Libraries\ApiResponse\ApiResponse;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseTest extends TestCase
{
    protected $apiResponse;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->apiResponse = new ApiResponse;
        $fakerFactory = new Faker\Factory();
        $this->faker = $fakerFactory->create();
    }

    public function test_response_json()
    {
        $response = $this->apiResponse->responseJson('Message', []);
        $this->assertInstanceOf(Illuminate\Http\JsonResponse::class, $response);
    }

    public function test_response_format()
    {
        $response = $this->apiResponse->setResponse('Message', ['email' => ['Is required']], [
            [
                'id'   => 1,
                'name' => 'Fake name'
            ]
        ], []);
        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('error', $response);
        $this->assertArrayHasKey('data', $response);
    }

    public function test_success_response_with_paginator()
    {
        $response = $this->apiResponse->success($this->faker->name,
            new LengthAwarePaginator([['id'   => 1, 'name' => 'Fake name']], 1, 10));

        $this->assertObjectHasAttribute('message', $response->getData());
        $this->assertObjectHasAttribute('data', $response->getData());
        $this->assertObjectHasAttribute('meta', $response->getData()); // Meta only show if data is LengthAwarePaginator
    }
}
