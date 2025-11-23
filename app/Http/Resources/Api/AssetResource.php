<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'asset_tag' => $this->asset_tag,
            'serial_number' => $this->serial_number,
            'model' => $this->model,
            'manufacturer' => $this->manufacturer,
            'category' => $this->category?->name,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'assigned_to' => $this->assigned_to_id ? [
                'id' => $this->assigned_to_id,
                'name' => $this->assignedTo?->name,
                'email' => $this->assignedTo?->email,
            ] : null,
            'location' => $this->location,
            'purchase_date' => $this->purchase_date?->toDateString(),
            'purchase_cost' => $this->purchase_cost,
            'warranty_months' => $this->warranty_months,
            'warranty_expires_at' => $this->warranty_expires_at?->toDateString(),
            'notes' => $this->notes,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
