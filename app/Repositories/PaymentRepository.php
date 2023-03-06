<?php

namespace App\Repositories;

use App\Models\BillPayment;
use App\Http\Resources\BillPaymentResource;

class PaymentRepository
{
    public function __construct(
        private readonly BillPayment $model,
    ) {
    }

    public function create(array $data)
    {
        try {
            $model = $this->model->create($data);
        } catch (QueryException $e) {
            throw $e;
        }

        return BillPaymentResource::make($model);
    }
}
