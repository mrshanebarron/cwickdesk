<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticket_number,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status?->name,
            'status_id' => $this->status_id,
            'priority' => $this->priority?->name,
            'priority_id' => $this->priority_id,
            'requester' => [
                'id' => $this->requester_id,
                'name' => $this->requester?->name,
                'email' => $this->requester?->email,
            ],
            'assigned_to' => $this->assigned_to_id ? [
                'id' => $this->assigned_to_id,
                'name' => $this->assignedTo?->name,
                'email' => $this->assignedTo?->email,
            ] : null,
            'asset' => $this->asset_id ? [
                'id' => $this->asset_id,
                'name' => $this->asset?->name,
                'asset_tag' => $this->asset?->asset_tag,
            ] : null,
            'template' => $this->template?->name,
            'due_at' => $this->due_at?->toISOString(),
            'resolved_at' => $this->resolved_at?->toISOString(),
            'closed_at' => $this->closed_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
