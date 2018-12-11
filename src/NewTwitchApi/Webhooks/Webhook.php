<?php

declare(strict_types=1);

namespace NewTwitchApi\Webhooks;

use GuzzleHttp\Client;
use NewTwitchApi\HelixGuzzleClient;

class Webhook
{
    public const SUBSCRIBE = 'subscribe';

    private $clientId;
    private $secret;
    private $leaseSeconds;
    private $guzzleClient;

    public function __construct(string $clientId, string $secret, int $leaseSeconds = 0, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->leaseSeconds = $leaseSeconds;
        $this->guzzleClient = $guzzleClient ?: new HelixGuzzleClient($clientId);
    }

    public function subscribeToStream(int $twitchId, string $bearer, string $callback): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $bearer,
            $callback
        );
    }

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribe(string $topic, string $bearer, string $callback): void
    {
        $headers = [
            'Authorization' => sprintf('Bearer %s', $bearer),
            'Client-ID' => $this->clientId,
        ];

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => self::SUBSCRIBE,
            'hub.topic' => $topic,
            'hub.lease_seconds' => $this->leaseSeconds,
            'hub.secret' => $this->secret,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }
}
