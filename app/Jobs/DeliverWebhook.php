<?php

namespace App\Jobs;

use App\Models\WebhookDelivery;
use App\Models\WebhookSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class DeliverWebhook implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min

    /**
     * Create a new job instance.
     */
    public function __construct(
        public WebhookSubscription $subscription,
        public string $event,
        public array $payload,
        public int $attempt = 1
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startTime = microtime(true);

        try {
            // Build headers
            $headers = array_merge(
                [
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'IT-Management-Webhooks/1.0',
                    'X-Webhook-Event' => $this->event,
                    'X-Webhook-Delivery' => (string) \Illuminate\Support\Str::uuid(),
                ],
                $this->subscription->headers ?? []
            );

            // Add signature if secret is configured
            if ($this->subscription->secret) {
                $headers['X-Webhook-Signature'] = $this->subscription->generateSignature($this->payload);
            }

            // Send webhook
            $response = Http::timeout(30)
                ->withHeaders($headers)
                ->post($this->subscription->url, $this->payload);

            $duration = microtime(true) - $startTime;
            $success = $response->successful();

            // Log delivery
            WebhookDelivery::create([
                'webhook_subscription_id' => $this->subscription->id,
                'event' => $this->event,
                'payload' => $this->payload,
                'response_code' => $response->status(),
                'response_body' => $response->body(),
                'duration' => $duration,
                'success' => $success,
                'attempt' => $this->attempt,
            ]);

            // Update subscription
            if ($success) {
                $this->subscription->update([
                    'last_delivered_at' => now(),
                    'last_error' => null,
                ]);
            } else {
                $this->subscription->update([
                    'last_failed_at' => now(),
                    'last_error' => "HTTP {$response->status()}: {$response->body()}",
                ]);

                // Retry if not max attempts
                if ($this->attempt < $this->subscription->retry_attempts) {
                    throw new \Exception("Webhook delivery failed with status {$response->status()}");
                }
            }
        } catch (\Exception $e) {
            $duration = microtime(true) - $startTime;

            // Log failed delivery
            WebhookDelivery::create([
                'webhook_subscription_id' => $this->subscription->id,
                'event' => $this->event,
                'payload' => $this->payload,
                'response_code' => null,
                'response_body' => $e->getMessage(),
                'duration' => $duration,
                'success' => false,
                'attempt' => $this->attempt,
            ]);

            $this->subscription->update([
                'last_failed_at' => now(),
                'last_error' => $e->getMessage(),
            ]);

            // Retry if not max attempts
            if ($this->attempt < $this->subscription->retry_attempts) {
                throw $e; // Will trigger Laravel's retry logic
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        $this->subscription->update([
            'last_failed_at' => now(),
            'last_error' => $exception->getMessage(),
        ]);
    }
}
