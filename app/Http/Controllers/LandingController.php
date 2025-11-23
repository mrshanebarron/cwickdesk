<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Landing page
     */
    public function index()
    {
        return view('landing.home', [
            'plans' => $this->getPricingPlans(),
        ]);
    }

    /**
     * Pricing page
     */
    public function pricing()
    {
        return view('landing.pricing', [
            'plans' => $this->getPricingPlans(),
        ]);
    }

    /**
     * Features page
     */
    public function features()
    {
        return view('landing.features', [
            'features' => $this->getFeaturesList(),
        ]);
    }

    /**
     * Get pricing plans
     */
    protected function getPricingPlans(): array
    {
        return [
            [
                'name' => 'Starter',
                'price' => 99,
                'interval' => 'month',
                'description' => 'Perfect for small IT teams',
                'stripe_price_id' => env('STRIPE_STARTER_PRICE_ID'),
                'features' => [
                    'Up to 10 users',
                    'Unlimited tickets',
                    '500 assets',
                    'Email support',
                    'Knowledge base',
                    'Mobile app',
                ],
                'limits' => [
                    'max_users' => 10,
                    'max_tickets_per_month' => null,
                    'max_assets' => 500,
                ],
            ],
            [
                'name' => 'Professional',
                'price' => 299,
                'interval' => 'month',
                'description' => 'For growing IT departments',
                'stripe_price_id' => env('STRIPE_PROFESSIONAL_PRICE_ID'),
                'popular' => true,
                'features' => [
                    'Up to 50 users',
                    'Unlimited tickets',
                    'Unlimited assets',
                    'Priority support',
                    'SSO (SAML/OAuth)',
                    'Advanced reporting',
                    'API access',
                    'Zapier integration',
                ],
                'limits' => [
                    'max_users' => 50,
                    'max_tickets_per_month' => null,
                    'max_assets' => null,
                ],
            ],
            [
                'name' => 'Enterprise',
                'price' => 799,
                'interval' => 'month',
                'description' => 'For large organizations',
                'stripe_price_id' => env('STRIPE_ENTERPRISE_PRICE_ID'),
                'features' => [
                    'Unlimited users',
                    'Unlimited everything',
                    'Dedicated account manager',
                    '24/7 phone support',
                    'Custom integrations',
                    'IP whitelisting',
                    'SLA guarantees',
                    'Audit logs',
                    'Custom branding',
                ],
                'limits' => [
                    'max_users' => null,
                    'max_tickets_per_month' => null,
                    'max_assets' => null,
                ],
            ],
        ];
    }

    /**
     * Get features list
     */
    protected function getFeaturesList(): array
    {
        return [
            [
                'name' => 'Ticketing System',
                'description' => 'Track and resolve IT issues with a powerful ticketing system',
                'icon' => 'ticket',
            ],
            [
                'name' => 'Asset Management',
                'description' => 'Track hardware, software licenses, and warranties in one place',
                'icon' => 'device-desktop',
            ],
            [
                'name' => 'Knowledge Base',
                'description' => 'Empower users with self-service documentation',
                'icon' => 'book-open',
            ],
            [
                'name' => 'Email Integration',
                'description' => 'Create tickets automatically from help@yourcompany.com',
                'icon' => 'mail',
            ],
            [
                'name' => 'Slack & Teams',
                'description' => 'Get notifications and create tickets from chat',
                'icon' => 'brand-slack',
            ],
            [
                'name' => 'SSO Authentication',
                'description' => 'Sign in with Microsoft or Google',
                'icon' => 'lock',
            ],
            [
                'name' => 'Zapier Integration',
                'description' => 'Connect to 5000+ apps without code',
                'icon' => 'plug',
            ],
            [
                'name' => 'REST API',
                'description' => 'Build custom integrations and automations',
                'icon' => 'code',
            ],
        ];
    }
}
