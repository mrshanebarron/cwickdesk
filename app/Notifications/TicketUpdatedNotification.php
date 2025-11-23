<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Ticket $ticket, public string $updateMessage = '')
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("Ticket Updated: {$this->ticket->ticket_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your support ticket has been updated.");

        if ($this->updateMessage) {
            $message->line("**Update:** {$this->updateMessage}");
        }

        return $message
            ->line("**Ticket Number:** {$this->ticket->ticket_number}")
            ->line("**Subject:** {$this->ticket->subject}")
            ->line("**Current Status:** {$this->ticket->status->name}")
            ->action('View Ticket', url("/ticket/lookup?ticket_number={$this->ticket->ticket_number}"))
            ->line('You can view the full ticket details and any new comments using the link above.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'subject' => $this->ticket->subject,
            'update_message' => $this->updateMessage,
        ];
    }
}
