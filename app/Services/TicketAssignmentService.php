<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Collection;

class TicketAssignmentService
{
    /**
     * Auto-assign a ticket to the most appropriate agent
     */
    public function autoAssign(Ticket $ticket): ?User
    {
        $agent = $this->findBestAgent($ticket);

        if ($agent) {
            $ticket->assigned_to = $agent->id;
            $ticket->save();
        }

        return $agent;
    }

    /**
     * Find the best agent to assign the ticket to
     * Uses round-robin with workload balancing
     */
    protected function findBestAgent(Ticket $ticket): ?User
    {
        // Get all agents (users with 'agent', 'admin', or 'super_admin' roles)
        $agents = User::role(['agent', 'admin', 'super_admin'])->get();

        if ($agents->isEmpty()) {
            return null;
        }

        // Get current open ticket count for each agent
        $agentWorkload = $agents->map(function ($agent) {
            return [
                'user' => $agent,
                'open_tickets' => Ticket::where('assigned_to', $agent->id)
                    ->whereHas('status', fn($q) => $q->where('is_resolved', false))
                    ->count(),
            ];
        });

        // Sort by workload (ascending) - assign to agent with fewest open tickets
        $agentWorkload = $agentWorkload->sortBy('open_tickets');

        // Return the agent with the lowest workload
        return $agentWorkload->first()['user'] ?? null;
    }

    /**
     * Reassign unassigned tickets
     */
    public function assignUnassignedTickets(): int
    {
        $unassignedTickets = Ticket::whereNull('assigned_to')
            ->whereHas('status', fn($q) => $q->where('is_resolved', false))
            ->get();

        $assignedCount = 0;

        foreach ($unassignedTickets as $ticket) {
            if ($this->autoAssign($ticket)) {
                $assignedCount++;
            }
        }

        return $assignedCount;
    }

    /**
     * Get workload distribution for all agents
     */
    public function getWorkloadDistribution(): Collection
    {
        $agents = User::role(['agent', 'admin', 'super_admin'])->get();

        return $agents->map(function ($agent) {
            return [
                'agent' => $agent,
                'open_tickets' => Ticket::where('assigned_to', $agent->id)
                    ->whereHas('status', fn($q) => $q->where('is_resolved', false))
                    ->count(),
                'resolved_today' => Ticket::where('assigned_to', $agent->id)
                    ->whereHas('status', fn($q) => $q->where('is_resolved', true))
                    ->whereDate('updated_at', today())
                    ->count(),
                'total_tickets' => Ticket::where('assigned_to', $agent->id)->count(),
            ];
        })->sortByDesc('open_tickets');
    }
}
