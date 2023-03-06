<?php

use App\Services\PaymentService;
use Carbon\Carbon;

beforeEach(function() {
    Http::preventStrayRequests();
    $this->service = $this->app->make(PaymentService::class);
});

test('should return update amounts', function() {

    $datePayment = Carbon::createFromFormat('Y-m-d', '2023-01-06');
    $dueDate = Carbon::createFromFormat('Y-m-d', '2023-03-06');
    $response = $this->service->returnUpdateAmount(100, $dueDate, $datePayment);

    $this->assertIsArray($response);
    $this->assertEquals($response['original_amount'], 100);

});