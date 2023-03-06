<?php

namespace Tests\Stubs;

use App\Events\BuildersEvent;

class NoopApiBuildersEvent extends BuildersEvent
{
    protected function getData(): array
    {
        return [
            'foo' => 'bar'
        ];
    }
}
