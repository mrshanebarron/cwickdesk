<?php

namespace App\Jobs;

use App\Models\SlackIntegration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendSlackNotification implements ShouldQueue
{
    use Queueable;

    public $tries = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SlackIntegration $integration,
        public string $event,
        public string $message,
        public array $blocks = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->integration->shouldNotifyFor($this->event)) {
            return; // Not configured to notify for this event
        }

        // Use webhook URL if available (simpler), otherwise use API
        if ($this->integration->webhook_url) {
            $this->sendViaWebhook();
        } elseif ($this->integration->bot_token) {
            $this->sendViaApi();
        }
    }

    protected function sendViaWebhook(): void
    {
        $payload = [
            'text' => $this->message,
        ];

        if (!empty($this->blocks)) {
            $payload['blocks'] = $this->blocks;
        }

        Http::post($this->integration->webhook_url, $payload);
    }

    protected function sendViaApi(): void
    {
        $payload = [
            'channel' => $this->integration->channel_id,
            'text' => $this->message,
        ];

        if (!empty($this->blocks)) {
            $payload['blocks'] = $this->blocks;
        }

        Http::withToken($this->integration->bot_token)
            ->post('https://slack.com/api/chat.postMessage', $payload);
    }
}
