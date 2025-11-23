<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with(['status', 'priority', 'requester', 'assignedTo', 'asset'])
            ->when($request->status, fn($q, $status) => $q->whereHas('status', fn($q) => $q->where('name', $status)))
            ->when($request->priority, fn($q, $priority) => $q->whereHas('priority', fn($q) => $q->where('name', $priority)))
            ->when($request->assigned_to, fn($q, $id) => $q->where('assigned_to_id', $id))
            ->when($request->requester, fn($q, $id) => $q->where('requester_id', $id))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return TicketResource::collection($tickets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'status_id' => 'nullable|exists:ticket_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'asset_id' => 'nullable|exists:assets,id',
            'due_at' => 'nullable|date',
        ]);

        $validated['requester_id'] = $request->user()->id;

        $ticket = Ticket::create($validated);

        // Fire webhook event
        event(new \App\Events\TicketCreated($ticket));

        return new TicketResource($ticket->load(['status', 'priority', 'requester', 'assignedTo', 'asset']));
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket->load(['status', 'priority', 'requester', 'assignedTo', 'asset', 'comments.user']));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'priority_id' => 'sometimes|exists:ticket_priorities,id',
            'status_id' => 'sometimes|exists:ticket_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'asset_id' => 'nullable|exists:assets,id',
            'due_at' => 'nullable|date',
        ]);

        $ticket->update($validated);

        // Fire webhook event
        event(new \App\Events\TicketUpdated($ticket));

        return new TicketResource($ticket->fresh(['status', 'priority', 'requester', 'assignedTo', 'asset']));
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully']);
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        $comment = $ticket->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment,
        ]);
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'assigned_to_id' => 'required|exists:users,id',
        ]);

        $ticket->update(['assigned_to_id' => $request->assigned_to_id]);

        // Fire webhook event
        event(new \App\Events\TicketAssigned($ticket));

        return new TicketResource($ticket->fresh(['status', 'priority', 'requester', 'assignedTo']));
    }

    public function close(Request $request, Ticket $ticket)
    {
        $ticket->update([
            'closed_at' => now(),
            'resolved_at' => $ticket->resolved_at ?? now(),
        ]);

        // Fire webhook event
        event(new \App\Events\TicketClosed($ticket));

        return new TicketResource($ticket->fresh());
    }

    public function reopen(Request $request, Ticket $ticket)
    {
        $ticket->update([
            'closed_at' => null,
            'resolved_at' => null,
        ]);

        return new TicketResource($ticket->fresh());
    }
}
