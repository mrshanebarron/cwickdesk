<?php

namespace App\Services;

use App\Jobs\DeliverWebhook;
use App\Models\WebhookSubscription;

class WebhookService
{
    /**
     * Dispatch webhooks for a given event
     */
    public static function dispatch(string $event, array $payload): void
    {
        $tenantId = app('currentTenant')?->id;

        if (!$tenantId) {
            return; // No tenant context, skip webhooks
        }

        // Find all active subscriptions for this event
        $subscriptions = WebhookSubscription::where('tenant_id', $tenantId)
            ->where('active', true)
            ->get()
            ->filter(fn($sub) => $sub->isSubscribedTo($event));

        foreach ($subscriptions as $subscription) {
            DeliverWebhook::dispatch($subscription, $event, $payload);
        }
    }

    /**
     * Available webhook events
     */
    public static function availableEvents(): array
    {
        return [
            'ticket.created',
            'ticket.updated',
            'ticket.assigned',
            'ticket.closed',
            'asset.created',
            'asset.updated',
            'asset.checked_out',
            'asset.checked_in',
            'kb.article.published',
            'user.created',
        ];
    }
}
