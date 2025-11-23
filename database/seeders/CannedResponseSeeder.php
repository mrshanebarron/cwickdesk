<?php

namespace Database\Seeders;

use App\Models\CannedResponse;
use Illuminate\Database\Seeder;

class CannedResponseSeeder extends Seeder
{
    public function run(): void
    {
        $responses = [
            [
                'title' => 'Password Reset - Instructions Sent',
                'category' => 'Password Reset',
                'content' => "I've reset your password and sent instructions to your email address on file. Please check your inbox (and spam folder) for an email from IT Support with your temporary password.\n\nOnce you receive it, please log in and change your password immediately.\n\nIf you don't receive the email within 10 minutes, please reply to this ticket.",
            ],
            [
                'title' => 'Password Reset - Completed',
                'category' => 'Password Reset',
                'content' => "Your password has been successfully reset. You should now be able to log in with your new credentials.\n\nFor security, please:\n1. Use a strong, unique password\n2. Never share your password with anyone\n3. Change your password regularly (every 90 days)\n\nIf you experience any further issues, please let us know.",
            ],
            [
                'title' => 'Ticket Received - Under Investigation',
                'category' => 'General',
                'content' => "Thank you for submitting your support request. I've received your ticket and am currently investigating the issue.\n\nI'll update you as soon as I have more information or a solution. In the meantime, if you have any additional details that might help, please reply to this ticket.\n\nExpected resolution time: Within 24 hours",
            ],
            [
                'title' => 'Network Issue - Escalated',
                'category' => 'Network',
                'content' => "I've identified that this is a network infrastructure issue and have escalated it to our network team for immediate attention.\n\nThey are aware of the urgency and are working on a resolution. I'll keep you updated on the progress.\n\nIn the meantime, you may want to:\n- Try connecting via mobile hotspot if urgent\n- Use the guest WiFi network if available\n- Work offline where possible",
            ],
            [
                'title' => 'Software Installation - Approved',
                'category' => 'Software',
                'content' => "Your software installation request has been approved. I'll be installing [SOFTWARE NAME] on your workstation.\n\nScheduled installation time: [DATE/TIME]\n\nPlease ensure:\n- Your computer is powered on and connected to the network\n- You've saved all your work before the installation\n- You're available for any required input during installation\n\nThe installation will take approximately 15-30 minutes.",
            ],
            [
                'title' => 'Hardware Replacement - Ordered',
                'category' => 'Hardware',
                'content' => "I've processed your hardware replacement request. The new [HARDWARE ITEM] has been ordered and should arrive within 3-5 business days.\n\nOnce it arrives, I'll schedule a time with you to:\n1. Install the new hardware\n2. Transfer your data (if applicable)\n3. Ensure everything is working properly\n\nI'll send you a tracking number when it ships.",
            ],
            [
                'title' => 'Printer Issue - Resolved',
                'category' => 'Printer',
                'content' => "I've resolved the printer issue. The problem was [BRIEF EXPLANATION].\n\nYou should now be able to print successfully. Please try printing a test page to confirm.\n\nIf you encounter any further issues with the printer, please let me know right away.",
            ],
            [
                'title' => 'Account Access - Granted',
                'category' => 'Access',
                'content' => "Your access request has been processed and approved. You now have access to:\n\n[LIST OF SYSTEMS/FOLDERS]\n\nPlease try logging in and confirm that you can access what you need. If you have any issues or need access to additional resources, please let me know.",
            ],
            [
                'title' => 'Email Issue - Resolved',
                'category' => 'Email',
                'content' => "I've resolved your email issue. The problem was [BRIEF EXPLANATION].\n\nYour email should now be working normally. Please:\n1. Try sending a test email\n2. Check that you can receive emails\n3. Verify your email signature is intact\n\nIf you continue to experience issues, please reply to this ticket.",
            ],
            [
                'title' => 'Remote Access - VPN Setup Complete',
                'category' => 'Remote Access',
                'content' => "Your VPN access has been configured successfully. You should now be able to connect to the company network from remote locations.\n\nConnection instructions:\n1. Open the VPN client\n2. Use your regular username and password\n3. Select the [COMPANY NAME] connection profile\n\nFor security:\n- Only connect from trusted networks\n- Always disconnect when finished\n- Never share your VPN credentials\n\nIf you have trouble connecting, please reply with the error message you receive.",
            ],
            [
                'title' => 'More Information Needed',
                'category' => 'General',
                'content' => "Thank you for your ticket. To help resolve this issue quickly, I need a bit more information:\n\n- When did you first notice this problem?\n- Does it happen every time or intermittently?\n- Have you tried restarting your computer?\n- Are you receiving any error messages? (If so, please provide the exact text)\n\nPlease reply with these details and I'll investigate right away.",
            ],
            [
                'title' => 'Ticket Resolved - Closing',
                'category' => 'General',
                'content' => "I'm marking this ticket as resolved since [BRIEF EXPLANATION OF RESOLUTION].\n\nIf you experience this issue again or have any other questions, please don't hesitate to submit a new ticket or reopen this one.\n\nThank you for your patience, and please let us know if there's anything else we can help you with!",
            ],
        ];

        foreach ($responses as $response) {
            CannedResponse::create(array_merge($response, [
                'is_active' => true,
                'usage_count' => 0,
                'created_by' => null, // System-created responses
            ]));
        }
    }
}
