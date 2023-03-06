<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(RefreshDatabase::class, WithFaker::class);

it('should be able to get access token via Builders API', function () {

    $response = Http::post(config('services.builders.auth_url'), config('services.builders.auth'));
    $responseData = $response->json();
    $this->assertArrayHasKey('token', $responseData);
});