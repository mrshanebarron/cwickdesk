<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'extension' => $this->extension,
            'cell' => $this->cell,
            'direct' => $this->direct,
            'building' => $this->building,
            'department' => $this->department,
            'area_of_responsibility' => $this->area_of_responsibility,
            'is_admin' => $this->is_admin,
            'is_agent' => $this->is_agent,
            'roles' => $this->getRoleNames(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
