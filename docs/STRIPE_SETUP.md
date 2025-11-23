# Stripe Setup Guide

## Overview

This application uses Laravel Cashier + Stripe for subscription billing. This guide walks through the complete Stripe setup process.

## Prerequisites

- Stripe account (sign up at https://stripe.com)
- Access to Stripe Dashboard
- Laravel Cashier already installed (`composer.json`)

## Step 1: Get API Keys

1. Go to [Stripe Dashboard](https://dashboard.stripe.com)
2. Navigate to **Developers → API keys**
3. Copy your keys:
   - **Publishable key**: Starts with `pk_test_` (for frontend)
   - **Secret key**: Starts with `sk_test_` (for backend)

Add to `.env`:
```env
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
```

## Step 2: Create Products and Prices

### Create Products

1. Go to **Products** in Stripe Dashboard
2. Click **Add product** for each plan:

#### Starter Plan
- **Name**: Starter Plan
- **Description**: Perfect for small IT teams
- **Pricing**: $99/month recurring
- **Copy the Price ID** (e.g., `price_1ABC123...`)

#### Professional Plan
- **Name**: Professional Plan
- **Description**: For growing IT departments
- **Pricing**: $299/month recurring
- **Copy the Price ID**

#### Enterprise Plan
- **Name**: Enterprise Plan
- **Description**: For large organizations
- **Pricing**: $799/month recurring
- **Copy the Price ID**

### Add Price IDs to .env

```env
STRIPE_STARTER_PRICE_ID=price_1ABC123starter
STRIPE_PROFESSIONAL_PRICE_ID=price_1ABC123pro
STRIPE_ENTERPRISE_PRICE_ID=price_1ABC123ent
```

## Step 3: Configure Webhooks

Stripe sends webhooks for subscription events (payment succeeded, failed, canceled, etc.). Laravel Cashier needs these to keep your database in sync.

### Create Webhook Endpoint

1. Go to **Developers → Webhooks** in Stripe Dashboard
2. Click **Add endpoint**
3. Enter endpoint URL:
   ```
   https://cwick.us/stripe/webhook
   ```
4. Select events to listen for:
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
   - `customer.updated`
   - `customer.deleted`
   - `invoice.payment_action_required`
   - `invoice.payment_succeeded`
   - `invoice.payment_failed`

5. Click **Add endpoint**
6. Copy the **Signing secret** (starts with `whsec_`)

Add to `.env`:
```env
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

### Local Testing with Stripe CLI

For local development, use the Stripe CLI to forward webhooks:

```bash
# Install Stripe CLI (macOS)
brew install stripe/stripe-cli/stripe

# Login to Stripe
stripe login

# Forward webhooks to local app
stripe listen --forward-to http://localhost:8000/stripe/webhook
```

The CLI will output a webhook signing secret - use this for `STRIPE_WEBHOOK_SECRET` locally.

## Step 4: Test the Signup Flow

### Use Test Card Numbers

Stripe provides test cards for different scenarios:

**Successful Payment:**
- Card: `4242 4242 4242 4242`
- Expiry: Any future date (e.g., 12/34)
- CVC: Any 3 digits (e.g., 123)
- ZIP: Any 5 digits (e.g., 12345)

**Declined Payment:**
- Card: `4000 0000 0000 0002`

**Requires Authentication (3D Secure):**
- Card: `4000 0027 6000 3184`

### Test Signup

1. Go to `https://cwick.us/signup?plan=professional`
2. Fill in company details:
   - **Company Name**: Test Company
   - **Subdomain**: testcompany (will create testcompany.cwick.us)
   - **Your Name**: John Doe
   - **Email**: john@testcompany.com
   - **Password**: password123
3. Enter test card: `4242 4242 4242 4242`
4. Submit

### Verify Tenant Created

After successful signup:
- Tenant created in database
- Subdomain active: `testcompany.cwick.us`
- Stripe Customer created
- Subscription created with 14-day trial
- Admin user created and assigned `super_admin` role

## Step 5: Monitor Subscriptions

### Stripe Dashboard

Monitor subscriptions in **Customers** section of Stripe Dashboard:
- View all customers
- Check subscription status (active, past_due, canceled)
- View payment history
- Manage invoices

### Application Database

Check subscription status in your database:

```sql
SELECT 
    tenants.name,
    tenants.domain,
    tenants.stripe_id,
    subscriptions.stripe_status,
    subscriptions.trial_ends_at,
    subscriptions.ends_at
FROM tenants
LEFT JOIN subscriptions ON tenants.id = subscriptions.tenant_id;
```

## Step 6: Handle Failed Payments

When a payment fails, Stripe will:
1. Send `invoice.payment_failed` webhook
2. Laravel Cashier updates subscription status to `past_due`
3. Retry payment automatically (Stripe's Smart Retries)

**Recommended Actions:**
- Email customer about failed payment
- Show banner in application: "Please update payment method"
- Grace period: 3-7 days before suspending service
- Suspend tenant access if payment not resolved

## Step 7: Cancellations and Refunds

### Customer Cancels Subscription

```php
$tenant->subscription('default')->cancel();
```

This marks subscription for cancellation at period end. Customer retains access until billing period ends.

### Immediate Cancellation

```php
$tenant->subscription('default')->cancelNow();
```

Access revoked immediately.

### Refunds (via Stripe Dashboard)

1. Go to **Payments** in Stripe Dashboard
2. Find the payment
3. Click **⋯** → **Refund payment**
4. Choose full or partial refund

## Step 8: Production Checklist

Before going live:

- [ ] Switch to **live API keys** (pk_live_ and sk_live_)
- [ ] Create **live products and prices** in Stripe
- [ ] Update **live Price IDs** in .env
- [ ] Configure **production webhook endpoint**
- [ ] Test signup flow with real card
- [ ] Enable **radar fraud prevention** in Stripe
- [ ] Set up **email receipts** in Stripe settings
- [ ] Configure **tax collection** (Stripe Tax)
- [ ] Review **subscription settings** (grace periods, retries)

## Pricing Plan Comparison

| Feature | Starter ($99) | Professional ($299) | Enterprise ($799) |
|---------|---------------|---------------------|-------------------|
| Users | 10 | 50 | Unlimited |
| Tickets | Unlimited | Unlimited | Unlimited |
| Assets | 500 | Unlimited | Unlimited |
| SSO | ❌ | ✅ | ✅ |
| API Access | ❌ | ✅ | ✅ |
| Zapier | ❌ | ✅ | ✅ |
| IP Whitelist | ❌ | ❌ | ✅ |
| Audit Logs | ❌ | ❌ | ✅ |
| Support | Email | Priority | 24/7 Phone |

## Troubleshooting

### "No such price" error

- Verify Price IDs in .env match Stripe Dashboard
- Ensure using correct environment (test vs live keys)

### Webhook signature verification failed

- Check `STRIPE_WEBHOOK_SECRET` matches Stripe Dashboard
- Ensure webhook endpoint URL is correct
- For local testing, use Stripe CLI forwarding

### Subscription not created

- Check Stripe Dashboard → Logs for errors
- Verify payment method is valid
- Check `laravel.log` for exceptions

### Customer charged but tenant not created

- Check database transaction rollback in `SignupController`
- Verify Stripe webhook is configured correctly
- Cashier will sync status via webhooks

## Resources

- [Laravel Cashier Docs](https://laravel.com/docs/billing)
- [Stripe API Docs](https://stripe.com/docs/api)
- [Stripe Testing](https://stripe.com/docs/testing)
- [Stripe CLI](https://stripe.com/docs/stripe-cli)
