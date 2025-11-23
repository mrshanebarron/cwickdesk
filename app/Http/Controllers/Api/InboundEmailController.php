<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\TicketPriority;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InboundEmailController extends Controller
{
    /**
     * Handle incoming email from SendGrid Inbound Parse
     *
     * POST /api/v1/inbound-email/{tenant}
     */
    public function handle(Request $request, string $tenantDomain)
    {
        // Find tenant by domain
        $tenant = Tenant::where('domain', $tenantDomain)->first();

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        // Set tenant context
        app()->instance('currentTenant', $tenant);

        // Parse email data from SendGrid
        $from = $request->input('from'); // "John Doe <john@example.com>"
        $to = $request->input('to');
        $subject = $request->input('subject');
        $text = $request->input('text'); // Plain text body
        $html = $request->input('html'); // HTML body
        $attachmentCount = (int) $request->input('attachments', 0);

        // Extract email address and name
        preg_match('/(?:(.+?)\s*<)?([^>]+@[^>]+)>?/', $from, $matches);
        $senderEmail = $matches[2] ?? $from;
        $senderName = trim($matches[1] ?? '') ?: explode('@', $senderEmail)[0];

        // Find or create user
        $user = User::where('email', $senderEmail)
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$user) {
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $senderName,
                'email' => $senderEmail,
                'password' => null, // Email-only users
            ]);
        }

        // Get default status and priority
        $status = TicketStatus::where('tenant_id', $tenant->id)
            ->where('name', 'Open')
            ->first();

        $priority = TicketPriority::where('tenant_id', $tenant->id)
            ->where('name', 'Normal')
            ->first();

        // Create ticket
        $ticket = Ticket::create([
            'tenant_id' => $tenant->id,
            'ticket_number' => 'T-' . strtoupper(Str::random(8)),
            'subject' => $subject ?: 'Email from ' . $senderEmail,
            'description' => $html ?: $text,
            'requester_id' => $user->id,
            'status_id' => $status?->id,
            'priority_id' => $priority?->id,
            'source' => 'email',
            'email_message_id' => $request->input('headers'), // Store for threading
        ]);

        // Handle attachments
        if ($attachmentCount > 0) {
            for ($i = 1; $i <= $attachmentCount; $i++) {
                if ($request->hasFile("attachment{$i}")) {
                    $file = $request->file("attachment{$i}");
                    $filename = $file->getClientOriginalName();

                    // Store file
                    $path = $file->store("tenants/{$tenant->id}/tickets/{$ticket->id}", 'public');

                    // Create attachment record
                    $ticket->attachments()->create([
                        'tenant_id' => $tenant->id,
                        'filename' => $filename,
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'uploaded_by' => $user->id,
                    ]);
                }
            }
        }

        // Fire webhook event
        event(new \App\Events\TicketCreated($ticket));

        return response()->json([
            'success' => true,
            'ticket_number' => $ticket->ticket_number,
            'message' => 'Ticket created from email',
        ], 201);
    }
}
