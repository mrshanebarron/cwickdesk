<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;

class SignupController extends Controller
{
    /**
     * Show signup form
     */
    public function index(Request $request)
    {
        $plan = $request->get('plan', 'professional'); // Default to professional

        $plans = [
            'starter' => [
                'name' => 'Starter',
                'price' => 49,
                'price_id' => env('STRIPE_STARTER_PRICE_ID'),
            ],
            'professional' => [
                'name' => 'Professional',
                'price' => 149,
                'price_id' => env('STRIPE_PROFESSIONAL_PRICE_ID'),
            ],
            'enterprise' => [
                'name' => 'Enterprise',
                'price' => 399,
                'price_id' => env('STRIPE_ENTERPRISE_PRICE_ID'),
            ],
        ];

        $selectedPlan = $plans[$plan] ?? $plans['professional'];

        return view('signup.index', [
            'plan' => $plan,
            'selectedPlan' => $selectedPlan,
            'stripeKey' => config('cashier.key'),
        ]);
    }

    /**
     * Process signup and create subscription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:50|alpha_dash|unique:tenants,slug',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'plan' => 'required|in:starter,professional,enterprise',
            'payment_method' => 'required|string', // Stripe payment method ID
            'terms_accepted' => 'accepted', // Must be checked
        ]);

        try {
            DB::beginTransaction();

            // Generate unique slug and domain
            $slug = Str::slug($validated['subdomain']);
            $domain = $slug . '.cwick.us';

            // Create tenant
            $tenant = Tenant::create([
                'name' => $validated['company_name'],
                'slug' => $slug,
                'domain' => $domain,
                'contact_name' => $validated['name'],
                'contact_email' => $validated['email'],
                'plan' => $validated['plan'],
                'status' => 'active',
                'is_internal' => false,
                'trial_ends_at' => now()->addDays(14), // 14-day trial
            ]);

            // Set tenant context for user creation
            app()->instance('currentTenant', $tenant);

            // Create admin user for tenant
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(),
            ]);

            // Assign super_admin role
            $user->assignRole('super_admin');

            // Create Stripe customer and subscription
            $tenant->createAsStripeCustomer([
                'name' => $validated['company_name'],
                'email' => $validated['email'],
            ]);

            // Get price ID based on plan
            $priceIds = [
                'starter' => env('STRIPE_STARTER_PRICE_ID'),
                'professional' => env('STRIPE_PROFESSIONAL_PRICE_ID'),
                'enterprise' => env('STRIPE_ENTERPRISE_PRICE_ID'),
            ];

            $priceId = $priceIds[$validated['plan']];

            // Create subscription with trial
            $tenant->newSubscription('default', $priceId)
                ->trialDays(14)
                ->create($validated['payment_method']);

            DB::commit();

            // Send welcome email (optional)
            // Mail::to($user)->send(new WelcomeEmail($tenant, $user));

            return redirect()->route('signup.success', ['tenant' => $tenant->slug]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Signup failed: ' . $e->getMessage());
        }
    }

    /**
     * Success page after signup
     */
    public function success(Request $request)
    {
        $tenantSlug = $request->get('tenant');
        $tenant = Tenant::where('slug', $tenantSlug)->firstOrFail();

        return view('signup.success', [
            'tenant' => $tenant,
            'loginUrl' => 'https://' . $tenant->domain . '/login',
        ]);
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request)
    {
        // Laravel Cashier handles most webhooks automatically
        // This is for custom webhook handling if needed

        return response()->json(['status' => 'success']);
    }
}
