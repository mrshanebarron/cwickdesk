<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeOnboarding extends Widget
{
    protected static ?string $heading = '';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        // Only show if user is authenticated and tenant has not completed onboarding
        if (!auth()->check()) {
            return false;
        }

        $tenant = app('currentTenant');

        if (!$tenant) {
            return false;
        }

        return !$tenant->onboarding_completed;
    }

    public function markStepComplete(string $step): void
    {
        $tenant = app('currentTenant');
        $steps = $tenant->onboarding_steps ?? [];
        $steps[$step] = true;
        $tenant->update(['onboarding_steps' => $steps]);

        // Check if all steps are complete
        $allSteps = ['welcome_viewed', 'team_invited', 'first_asset', 'first_ticket', 'kb_explored'];
        $completedSteps = array_filter($steps);

        if (count($completedSteps) >= 3) { // Mark complete after 3 steps
            $tenant->update(['onboarding_completed' => true]);
        }
    }

    public function dismissOnboarding(): void
    {
        $tenant = app('currentTenant');
        $tenant->update(['onboarding_completed' => true]);
    }

    public function getSteps(): array
    {
        $tenant = app('currentTenant');
        $completedSteps = $tenant->onboarding_steps ?? [];

        return [
            [
                'id' => 'welcome_viewed',
                'title' => 'Welcome to CwickDesk!',
                'description' => 'Get started by exploring your new IT management platform',
                'icon' => '👋',
                'completed' => $completedSteps['welcome_viewed'] ?? false,
            ],
            [
                'id' => 'team_invited',
                'title' => 'Invite Your Team',
                'description' => 'Add team members to collaborate on tickets and assets',
                'icon' => '👥',
                'action' => '/admin/users',
                'action_label' => 'Add Team Member',
                'completed' => $completedSteps['team_invited'] ?? false,
            ],
            [
                'id' => 'first_asset',
                'title' => 'Add Your First Asset',
                'description' => 'Track hardware, software, and equipment inventory',
                'icon' => '💻',
                'action' => '/admin/assets',
                'action_label' => 'Add Asset',
                'completed' => $completedSteps['first_asset'] ?? false,
            ],
            [
                'id' => 'first_ticket',
                'title' => 'Create a Test Ticket',
                'description' => 'See how our ticketing system helps you manage support requests',
                'icon' => '🎫',
                'action' => '/admin/tickets',
                'action_label' => 'Create Ticket',
                'completed' => $completedSteps['first_ticket'] ?? false,
            ],
            [
                'id' => 'kb_explored',
                'title' => 'Build Your Knowledge Base',
                'description' => 'Document procedures and create helpful guides for your team',
                'icon' => '📚',
                'action' => '/admin/kb-articles',
                'action_label' => 'Add Article',
                'completed' => $completedSteps['kb_explored'] ?? false,
            ],
        ];
    }

    protected function getViewData(): array
    {
        return [
            'steps' => $this->getSteps(),
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.admin.widgets.welcome-onboarding', $this->getViewData());
    }
}
