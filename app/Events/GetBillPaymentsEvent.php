<?php

namespace App\Events;

final class GetBillPaymentsEvent extends BuildersEvent
{
    public function __construct(
        public readonly string $code,
    ) {
    }

    /** @inheritDoc */
    public function getData(): array
    {
        return [
            'code' => $this->code
        ];
    }
}
