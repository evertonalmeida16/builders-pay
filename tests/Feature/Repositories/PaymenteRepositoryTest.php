<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BillPayment;

uses(RefreshDatabase::class, WithFaker::class);

it('should be able to create a bill payment', function () {
    $data = [
        'original_amount' => 100,
        'amount' => 120,
        'due_date' => '2023-01-06',
        'payment_date' => '2023-02-06',
        'interest_amount_calculated' => 10,
        'fine_amount_calculated' => 10
    ];

    $billPayment = BillPayment::create($data);

    $this->assertDatabaseHas('bill_payments', $data);
    $this->assertEquals($data['amount'], $billPayment->amount);
    $this->assertEquals($data['due_date'], $billPayment->due_date);
});