<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketResolvedNotification;
use App\Notifications\TicketUpdatedNotification;
use App\Services\TicketAssignmentService;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        // Auto-assign the ticket if not already assigned
        if (!$ticket->assigned_to) {
            $assignmentService = app(TicketAssignmentService::class);
            $assignedAgent = $assignmentService->autoAssign($ticket);

            // Refresh the ticket to get the updated assigned_to
            $ticket->refresh();
        }

        // Notify the requester that their ticket was created
        $ticket->requester->notify(new TicketCreatedNotification($ticket));
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        // Check if assignment changed
        if ($ticket->wasChanged('assigned_to')) {
            $oldAssignee = $ticket->getOriginal('assigned_to');
            $newAssignee = $ticket->assigned_to;

            // Notify new assignee
            if ($newAssignee && $ticket->assignedTo) {
                $ticket->assignedTo->notify(new TicketAssignedNotification($ticket));
            }
        }

        // Check if status changed to resolved
        if ($ticket->wasChanged('status_id')) {
            $newStatus = $ticket->status;
            if ($newStatus && $newStatus->is_resolved) {
                // Notify requester that ticket is resolved
                $ticket->requester->notify(new TicketResolvedNotification($ticket));
            }
        }

        // For any other updates, notify requester (except if just created)
        if (!$ticket->wasRecentlyCreated && $ticket->wasChanged() && !$ticket->wasChanged('view_count')) {
            // Only notify if meaningful fields changed
            $meaningfulChanges = $ticket->wasChanged(['status_id', 'priority_id', 'assigned_to', 'subject', 'description']);
            if ($meaningfulChanges) {
                $ticket->requester->notify(new TicketUpdatedNotification($ticket));
            }
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
