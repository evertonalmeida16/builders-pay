<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Services\ApiBuildersService;
use App\Events\GetBillPaymentsEvent;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class PaymentService
{
    public function __construct(
        private readonly PaymentRepository $repository,
        private readonly ApiBuildersService $apiService,
    ) {
    }

    public function calcRate(array $data): JsonResponse
    {   

        $billPaymentEvent = new GetBillPaymentsEvent($data['bar_code']);
        $responseBillPayment = $this->apiService->send($billPaymentEvent);

        if($responseBillPayment && $responseBillPayment['type'] != 'NPC') {
            throw new HttpResponseException(response()->json(['errors' => 'Tipo de boleto inválido!'], 422));
        }

        $datePayment = Carbon::createFromFormat('Y-m-d', $data['payment_date']);
        $dueDate = Carbon::createFromFormat('Y-m-d', $responseBillPayment['due_date']);
        $responseUpdateAmount = $this->returnUpdateAmount($responseBillPayment['amount'], $dueDate, $datePayment);

        $saveUpdatedValues = $this->repository->create($responseUpdateAmount);

        return response()->json($saveUpdatedValues, Response::HTTP_OK);
    }

    public function returnUpdateAmount($amount, $dueDate, $datePayment): array
    {
        $daysDelay = $dueDate->diffInDays($datePayment, false);

        $interestAmount = 0;
        $fineAmount = 0;
        if ($daysDelay > 0) {
            $interestAmount = $amount * (0.0333 / 100) * $daysDelay;
            $fineAmount = $amount * 0.02;
        }
        
        $finalValue = $amount + $interestAmount + $fineAmount;

        $updatedValues = [
            'original_amount' => (float) number_format($amount, 2, '.', ''),
            'amount' => (float) number_format($finalValue, 2, '.', ''),
            'due_date' => Carbon::parse($dueDate)->format('Y-m-d'),
            'payment_date' => Carbon::parse($datePayment)->format('Y-m-d'),
            'interest_amount_calculated' => (float) number_format($interestAmount, 2, '.', ''),
            'fine_amount_calculated' => (float) number_format($fineAmount, 2, '.', '')
        ];

        return $updatedValues;
    }
}
