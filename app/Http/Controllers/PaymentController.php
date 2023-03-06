<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRateRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $service,
    ) {
    }


    public function calcRate(CalcRateRequest $request)
    {
        return $this->service->calcRate($request->validated());
    }

}
