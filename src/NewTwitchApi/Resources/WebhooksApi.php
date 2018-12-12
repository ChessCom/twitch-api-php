<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use NewTwitchApi\RequestResponse;

class WebhooksApi extends AbstractResource
{
    /**
     * @link https://dev.twitch.tv/docs/api/reference/#get-webhook-subscriptions
     */
    public function getWebhookSubscriptions(string $accessToken, string $first = null, string $after = null): RequestResponse
    {
        $queryParamsMap = [];
        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }
        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->callApi('webhooks/subscriptions', $queryParamsMap, $accessToken);
    }
}
