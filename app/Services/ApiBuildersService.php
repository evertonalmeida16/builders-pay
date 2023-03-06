<?php

namespace App\Services;

use App\Events\BuildersEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiBuildersService
{
    /**
     * Return a default new HTTP request.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    private function getRequest()
    {
        return Http::withoutVerifying();
    }

    /**
     * Get the authentication code for using BuildersAPI.
     *
     * @return string
     */
    private function getAccessToken(): ?string
    {
        return Cache::remember('builders-token', new \DateInterval('PT13M'), function() {
            $response = $this->getRequest()->post(
                config('services.builders.auth_url'),
                config('services.builders.auth'),
            );

            if (!$response->successful()) {
                throw new \RuntimeException($response->body());
            }

            return $response->json('token');
        });
    }

    /**
     * Send a request to BuildersAPI's API.
     *
     * @param \App\Events\BuildersEvent $data The data object to be sent.
     *
     * @return array The response for the request.
     */
    public function send(BuildersEvent $data): array
    {
        try {
            $response = $this->getRequest()
                ->asJson()
                ->withHeaders(['Authorization' => $this->getAccessToken()])
                ->post(
                    config('services.builders.url_payment'),
                    $data->getParams()
                );

            if (!$response->successful()) {
                throw new \RuntimeException($response->json(), $response->status());
            }

            return $response->json() ?: [];
        } catch (\Exception $e) {

            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
