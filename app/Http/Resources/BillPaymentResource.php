<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BillPayment */
class BillPaymentResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'original_amount' => $this->original_amount,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'payment_date' => $this->payment_date,
            'interest_amount_calculated' => $this->interest_amount_calculated,
            'fine_amount_calculated' => $this->fine_amount_calculated
        ];
    }
}
