<?php

declare(strict_types=1);

namespace TwitchApi\NewApi\Webhooks;

use GuzzleHttp\Client;
use TwitchApi\NewApi\HelixGuzzleClient;

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
        $this->guzzleClient = $guzzleClient ?: new HelixGuzzleClient();
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getLeaseSeconds(): int
    {
        return $this->leaseSeconds;
    }

    public function subscribeToStream(int $twitchId, string $accessToken, string $callback): void
    {
        $topic = sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId);
        $headers = [
            'Authorization' => sprintf('Bearer %s', $accessToken),
            'Client-ID' => $this->getClientId(),
        ];
        $this->subscribe($topic, $callback, $headers);
    }

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribe(string $topic, string $callback, array $headers = []): void
    {
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
