<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $assets = Asset::with(['category', 'assignedTo'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->assigned_to, fn($q, $id) => $q->where('assigned_to_id', $id))
            ->when($request->search, fn($q, $search) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_tag', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate($request->per_page ?? 15);

        return AssetResource::collection($assets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_tag' => 'required|string|unique:assets,asset_tag',
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'category_id' => 'nullable|exists:asset_categories,id',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'warranty_months' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $asset = Asset::create($validated);

        event(new \App\Events\AssetCreated($asset));

        return new AssetResource($asset->load('category'));
    }

    public function show(Asset $asset)
    {
        return new AssetResource($asset->load(['category', 'assignedTo']));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'asset_tag' => 'sometimes|string|unique:assets,asset_tag,' . $asset->id,
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'category_id' => 'nullable|exists:asset_categories,id',
            'status' => 'sometimes|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'warranty_months' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $asset->update($validated);

        event(new \App\Events\AssetUpdated($asset));

        return new AssetResource($asset->fresh(['category', 'assignedTo']));
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully']);
    }

    public function checkout(Request $request, Asset $asset)
    {
        $request->validate([
            'assigned_to_id' => 'required|exists:users,id',
        ]);

        $asset->update([
            'assigned_to_id' => $request->assigned_to_id,
            'status' => 'in_use',
        ]);

        event(new \App\Events\AssetCheckedOut($asset));

        return new AssetResource($asset->fresh(['category', 'assignedTo']));
    }

    public function checkin(Request $request, Asset $asset)
    {
        $asset->update([
            'assigned_to_id' => null,
            'status' => 'available',
        ]);

        event(new \App\Events\AssetCheckedIn($asset));

        return new AssetResource($asset->fresh(['category']));
    }
}
