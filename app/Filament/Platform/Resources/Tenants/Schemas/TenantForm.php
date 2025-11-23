<?php

namespace App\Filament\Platform\Resources\Tenants\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tenant Information')
                    ->description('Basic information about the tenant')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (! $get('domain')) {
                                    $set('slug', Str::slug($state));
                                    $set('domain', Str::slug($state) . '.cwick.us');
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null),
                        TextInput::make('domain')
                            ->label('Domain')
                            ->helperText('Full domain (e.g., acme.cwick.us)')
                            ->required(),
                        Toggle::make('is_internal')
                            ->label('Internal Tenant')
                            ->helperText('Internal tenants are not billed')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('contact_name')
                            ->label('Contact Name'),
                        TextInput::make('contact_email')
                            ->email()
                            ->label('Contact Email'),
                        TextInput::make('contact_phone')
                            ->tel()
                            ->label('Contact Phone'),
                    ])
                    ->columns(3),

                Section::make('Subscription & Billing')
                    ->schema([
                        Select::make('plan')
                            ->options([
                                'free' => 'Free',
                                'starter' => 'Starter',
                                'professional' => 'Professional',
                                'enterprise' => 'Enterprise',
                            ])
                            ->required()
                            ->default('free'),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'trial' => 'Trial',
                                'suspended' => 'Suspended',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('trial')
                            ->required(),
                        DateTimePicker::make('trial_ends_at')
                            ->label('Trial Ends At'),
                        TextInput::make('stripe_id')
                            ->label('Stripe Customer ID')
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('Limits & Quotas')
                    ->schema([
                        TextInput::make('max_users')
                            ->required()
                            ->numeric()
                            ->default(5)
                            ->minValue(1)
                            ->label('Max Users'),
                        TextInput::make('max_tickets_per_month')
                            ->numeric()
                            ->label('Max Tickets/Month'),
                        TextInput::make('max_assets')
                            ->numeric()
                            ->label('Max Assets'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Customization')
                    ->schema([
                        TextInput::make('logo_url')
                            ->url()
                            ->label('Logo URL'),
                        ColorPicker::make('primary_color')
                            ->default('#3b82f6')
                            ->label('Primary Color'),
                        ColorPicker::make('secondary_color')
                            ->label('Secondary Color'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Security')
                    ->schema([
                        Toggle::make('ip_whitelist_enabled')
                            ->label('IP Whitelist Enabled')
                            ->default(false),
                        Textarea::make('ip_whitelist')
                            ->label('IP Whitelist')
                            ->helperText('One IP per line')
                            ->rows(3)
                            ->visible(fn ($get) => $get('ip_whitelist_enabled')),
                    ])
                    ->collapsible(),
            ]);
    }
}
