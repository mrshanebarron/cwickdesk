<?php

namespace Database\Seeders;

use App\Models\TicketPriority;
use App\Models\TicketTemplate;
use Illuminate\Database\Seeder;

class TicketTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $mediumPriority = TicketPriority::where('name', 'Medium')->first();
        $highPriority = TicketPriority::where('name', 'High')->first();
        $lowPriority = TicketPriority::where('name', 'Low')->first();

        $templates = [
            [
                'name' => 'Password Reset',
                'subject' => 'I need my password reset',
                'description' => "I cannot log in to my account and need my password reset.\n\nUsername: [YOUR USERNAME]\nLast successful login: [DATE/TIME if you remember]\n\nPlease send reset instructions to this email address.",
                'priority_id' => $mediumPriority?->id,
                'icon' => 'heroicon-o-key',
                'color' => 'warning',
                'sort_order' => 1,
            ],
            [
                'name' => 'New Computer Setup',
                'subject' => 'New computer setup request',
                'description' => "I need a new computer set up for:\n\nEmployee Name: [NAME]\nDepartment: [DEPARTMENT]\nStart Date: [DATE]\nRequired Software: [LIST SOFTWARE NEEDED]\n\nPlease configure email, network access, and standard software.",
                'priority_id' => $mediumPriority?->id,
                'icon' => 'heroicon-o-computer-desktop',
                'color' => 'info',
                'sort_order' => 2,
            ],
            [
                'name' => 'Printer Not Working',
                'subject' => 'Printer is not working',
                'description' => "I'm having problems with the printer.\n\nPrinter Name/Location: [LOCATION]\nProblem Description: [DESCRIBE ISSUE]\nError Message (if any): [ERROR MESSAGE]\n\nI have tried:\n- Restarting the printer: Yes/No\n- Checking paper and toner: Yes/No\n- Restarting my computer: Yes/No",
                'priority_id' => $lowPriority?->id,
                'icon' => 'heroicon-o-printer',
                'color' => 'gray',
                'sort_order' => 3,
            ],
            [
                'name' => 'Software Installation',
                'subject' => 'Software installation request',
                'description' => "I need the following software installed:\n\nSoftware Name: [NAME]\nVersion (if specific): [VERSION]\nPurpose: [WHY YOU NEED IT]\nUrgency: [ASAP / This Week / No Rush]\n\nI have obtained approval from my manager: Yes/No\nManager Name: [NAME]",
                'priority_id' => $lowPriority?->id,
                'icon' => 'heroicon-o-arrow-down-tray',
                'color' => 'success',
                'sort_order' => 4,
            ],
            [
                'name' => 'Network/WiFi Issues',
                'subject' => 'I cannot connect to the network/WiFi',
                'description' => "I'm experiencing network connectivity issues.\n\nConnection Type: WiFi / Ethernet\nLocation: [BUILDING/FLOOR/ROOM]\nError Message: [IF ANY]\n\nI have tried:\n- Restarting my computer: Yes/No\n- Disconnecting and reconnecting: Yes/No\n- Other devices working in same location: Yes/No",
                'priority_id' => $highPriority?->id,
                'icon' => 'heroicon-o-wifi',
                'color' => 'danger',
                'sort_order' => 5,
            ],
            [
                'name' => 'Email Issues',
                'subject' => 'Email not working properly',
                'description' => "I'm having problems with my email.\n\nProblem Type:\n[ ] Cannot send emails\n[ ] Cannot receive emails\n[ ] Emails going to spam\n[ ] Cannot access mailbox\n[ ] Other: [DESCRIBE]\n\nError Messages: [IF ANY]\nWhen did this start: [DATE/TIME]",
                'priority_id' => $highPriority?->id,
                'icon' => 'heroicon-o-envelope',
                'color' => 'warning',
                'sort_order' => 6,
            ],
            [
                'name' => 'Hardware Problem',
                'subject' => 'Hardware malfunction or damage',
                'description' => "I'm experiencing a hardware issue.\n\nDevice Type: [Computer / Monitor / Keyboard / Mouse / Other]\nProblem Description: [DESCRIBE ISSUE]\nIs it still under warranty: [YES/NO/DON'T KNOW]\nDoes this prevent you from working: Yes/No",
                'priority_id' => $mediumPriority?->id,
                'icon' => 'heroicon-o-wrench-screwdriver',
                'color' => 'warning',
                'sort_order' => 7,
            ],
            [
                'name' => 'Access Request',
                'subject' => 'Request access to [SYSTEM/FOLDER]',
                'description' => "I need access to the following:\n\nSystem/Folder Name: [NAME]\nType of Access Needed: [Read Only / Read and Write / Admin]\nReason for Access: [EXPLANATION]\nManager Approval: [MANAGER NAME]\n\nThis access is needed by: [DATE]",
                'priority_id' => $lowPriority?->id,
                'icon' => 'heroicon-o-lock-open',
                'color' => 'info',
                'sort_order' => 8,
            ],
        ];

        foreach ($templates as $template) {
            TicketTemplate::create($template);
        }
    }
}
