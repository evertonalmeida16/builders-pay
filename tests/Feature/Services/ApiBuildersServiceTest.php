<?php

use App\Services\ApiBuildersService;
use Illuminate\Support\Facades\Http;
use Tests\Stubs\NoopApiBuildersEvent;

beforeEach(function() {
    Http::preventStrayRequests();
    $this->service = $this->app->make(ApiBuildersService::class);
});

test('should make a request and return the response', function() {
    Http::fake([
        config('services.builders.auth_url') => Http::response(['token' => '123']),
        config('services.builders.url_payment') => Http::response(['message' => 'ok']),
    ]);

    $response = $this->service->send($event = new NoopApiBuildersEvent());

    expect($response)->toBe(['message' => 'ok']);
    Http::assertSentCount(2);
    [$request] = Http::recorded()[1];
    expect($request->isJson())->toBeTrue()
        ->and($request->hasHeader('Authorization', '123'))->toBeTrue()
        ->and($request->url())->toBe(config('services.builders.url_payment'))
        ->and($request->data())->toBe($event->getParams());
});

test('should authenticate only 1 time - token cache', function() {
    Http::fake([
        config('services.builders.auth_url') => Http::response(['token' => '123']),
        '*' => Http::response(),
    ]);

    $this->service->send(new NoopApiBuildersEvent());
    $this->service->send(new NoopApiBuildersEvent());

    Http::assertSentCount(3);
});

test('should return authentication error', function() {
    Http::fake([
        config('services.builders.auth_url') => fn() => Http::response(['error' => 'foo'], 401),
    ]);

    $response = $this->service->send(new NoopApiBuildersEvent());

    expect($response)->toBe([
        'error' => true,
        'message' => json_encode(['error' => 'foo']),
    ]);
});
