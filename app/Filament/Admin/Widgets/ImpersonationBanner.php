<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class ImpersonationBanner extends Widget
{
    protected static ?string $heading = '';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->isImpersonated();
    }

    protected function getViewData(): array
    {
        return [];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.admin.widgets.impersonation-banner');
    }
}
