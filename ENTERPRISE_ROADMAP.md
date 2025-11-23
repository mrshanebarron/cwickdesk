# Enterprise-Grade Feature Roadmap

**Status:** Deferred Post-Revenue (Revenue Velocity First)
**Purpose:** Long-term roadmap to capture enterprise customers ($500-2000/month tier)

---

## Strategic Approach

**Phase 1 (Current):** Build MVP, get to revenue, dog-food at Danielle Fence
**Phase 2 (Post-Revenue):** Add enterprise features as customers request them
**Phase 3 (Scale):** Pursue compliance certifications and high-value contracts

**Why defer these features:**
- Retention features, not acquisition features
- Time-intensive to build correctly
- Only needed once we have paying customers asking for them
- Revenue enables investment in these features

---

## Pillar 1: Advanced Security & Compliance

### Single Sign-On (SSO)

**Business Value:**
- Eliminates "one more password" friction
- Required by most enterprises (100+ employees)
- Enables faster user onboarding/offboarding
- Reduces support burden (no password resets)

**Technical Implementation:**
- **RECOMMENDED:** Use package (NOT custom) - `aacotroneo/laravel-saml2` for SAML
- Laravel Socialite for OIDC providers (Microsoft, Google)
- Security-critical: Too complex to roll custom solution safely
- Packages provide configuration/extension points for flexibility

**Gemini's Strong Recommendation:**
> "Building custom SSO is a highly complex, security-critical task with significant ongoing maintenance and potential for vulnerabilities. Use a well-maintained package."

**Database Schema:**
```php
// Add to tenants table
$table->string('sso_provider')->nullable(); // 'saml', 'oidc', 'microsoft', 'google'
$table->json('sso_config')->nullable(); // Provider-specific settings
$table->boolean('sso_required')->default(false); // Force SSO for all users

// Add to users table (already have these)
$table->string('sso_provider')->nullable();
$table->string('sso_id')->nullable();
$table->json('sso_data')->nullable();
```

**Pricing Tier:** Pro ($299/mo) or Enterprise ($499/mo)

**Estimated Effort:** 2-3 weeks (including testing with multiple providers)

---

### Fine-Grained RBAC (Role-Based Access Control)

**Business Value:**
- Custom roles for complex organizational structures
- Compliance requirement (principle of least privilege)
- Enables delegation without over-permission

**Current State:**
- Spatie Laravel Permission installed
- Basic roles: platform_admin, super_admin, admin
- Need to add granular permissions

**Granular Permissions Needed:**

**Tickets:**
- `tickets.view.all` - View all tickets
- `tickets.view.assigned` - Only assigned tickets
- `tickets.view.department` - Department tickets
- `tickets.create` - Create new tickets
- `tickets.edit.all` - Edit any ticket
- `tickets.edit.assigned` - Edit assigned tickets
- `tickets.delete` - Delete tickets
- `tickets.assign` - Assign tickets
- `tickets.close` - Close tickets
- `tickets.reopen` - Reopen closed tickets

**Assets:**
- `assets.view` - View assets
- `assets.create` - Create assets
- `assets.edit` - Edit assets
- `assets.delete` - Delete assets
- `assets.checkout` - Checkout to users
- `assets.checkin` - Check in assets

**Knowledge Base:**
- `kb.view.published` - View published articles
- `kb.view.draft` - View draft articles
- `kb.create` - Create articles
- `kb.edit` - Edit articles
- `kb.publish` - Publish articles
- `kb.delete` - Delete articles

**Reports:**
- `reports.view` - View reports
- `reports.export` - Export data
- `reports.custom` - Create custom reports

**Administration:**
- `users.manage` - Manage users
- `settings.manage` - Manage settings
- `billing.manage` - Manage billing

**Technical Implementation:**
- Spatie Permission already supports this
- Create seeder for all permissions
- Filament shield for UI management
- Role builder interface for admins

**Pricing Tier:** Pro ($299/mo) and above

**Estimated Effort:** 1-2 weeks

---

### Comprehensive Audit Logs

**Business Value:**
- Compliance requirement (SOC 2, HIPAA, GDPR)
- Security incident investigation
- User accountability
- Change tracking

**Current State:**
- Basic activity log table exists
- `LogsActivity` trait on models
- Need to expand coverage

**What to Log:**

**User Actions:**
- Login/logout (with IP, device, location)
- Failed login attempts
- Password changes
- Permission changes
- SSO authentication

**Data Changes:**
- Ticket created/updated/deleted/assigned/closed
- Asset created/updated/deleted/checked out/checked in
- User created/updated/deleted/role changed
- Settings changes
- KB article published/unpublished

**Administrative Actions:**
- Role assignments
- Permission changes
- Integration configurations
- Billing changes
- Export operations

**Log Format:**
```php
[
    'event' => 'ticket.assigned',
    'actor_id' => 5,
    'actor_name' => 'John Smith',
    'subject_type' => 'Ticket',
    'subject_id' => 123,
    'changes' => [
        'assigned_to' => ['old' => 3, 'new' => 5]
    ],
    'ip_address' => '192.168.1.100',
    'user_agent' => 'Mozilla/5.0...',
    'tenant_id' => 1,
    'created_at' => '2025-11-23 15:30:00'
]
```

**Features:**
- Immutable logs (no updates/deletes)
- Searchable and filterable
- Exportable (CSV, JSON)
- Real-time display in admin panel
- Retention policy (configurable by plan)

**Technical Implementation:**
- Expand `LogsActivity` trait
- Add logging middleware for sensitive operations
- Filament resource for viewing logs
- Export functionality
- Consider package: `spatie/laravel-activitylog`

**Pricing Tier:** Pro ($299/mo) - 90 days retention, Enterprise ($499/mo) - unlimited

**Estimated Effort:** 1 week

---

### Compliance Certifications

**Business Value:**
- Required for enterprise contracts
- Competitive differentiation
- Premium pricing justification
- Trust signal

**Certifications to Pursue:**

**SOC 2 Type II** (Priority 1)
- Security, Availability, Processing Integrity, Confidentiality, Privacy
- Audit performed by 3rd party
- Required by most enterprises
- Cost: $15,000-50,000
- Timeline: 6-12 months
- **MRR Threshold (Gemini):** $20-30k minimum before investment
  - Validates product-market fit
  - Financial stability to absorb cost and ongoing overhead
  - Signals transition from early-stage to enterprise-ready

**ISO 27001** (Priority 2)
- Information Security Management System
- Global standard
- Cost: $20,000-80,000
- Timeline: 6-12 months

**HIPAA Compliance** (If healthcare customers)
- Required for healthcare data
- BAA (Business Associate Agreement) required
- Significant infrastructure changes

**GDPR Compliance** (EU customers)
- Already partially compliant (data encryption, user deletion)
- Need: Data Processing Agreement (DPA), Privacy Shield, data residency

**Prerequisites:**
- Security policies documented
- Penetration testing
- Incident response plan
- Data encryption at rest and in transit
- Regular backups with tested restore
- Vendor risk management

**Pricing Impact:** Enterprise tier ($499-999/mo)

**Estimated Effort:** 6-12 months + ongoing

---

## Pillar 2: Deep Integration Capabilities

### Public API & Webhooks

**Business Value:**
- Custom integrations for unique workflows
- Automation of repetitive tasks
- Data sync with other systems
- Developer ecosystem

**API Requirements:**

**REST API (V1 - Recommended by Gemini):**
- Full CRUD operations on all resources
- Pagination, filtering, sorting
- Rate limiting (by plan tier)
- Comprehensive documentation (OpenAPI/Swagger)
- Versioning (v1, v2)
- Authentication: API tokens, OAuth 2.0

**Endpoints:**
```
/api/v1/tickets
/api/v1/assets
/api/v1/users
/api/v1/kb-articles
/api/v1/reports
```

**Why REST First (Gemini's Rationale):**
- Simple, widespread understanding, broad compatibility
- Lower learning curve for small business customers
- Ideal for basic scripts and Zapier integrations
- Covers most initial integration needs efficiently
- **GraphQL later** if complex data fetching needs emerge from power users

**Webhooks:**
- Real-time event notifications
- Configurable endpoints
- Retry logic with exponential backoff
- Signature verification (HMAC)
- Event types:
  - `ticket.created`
  - `ticket.updated`
  - `ticket.assigned`
  - `ticket.closed`
  - `asset.created`
  - `asset.checked_out`
  - `kb.article.published`
  - `user.created`

**Technical Implementation:**
- Laravel Sanctum or Passport for API auth
- API Resources for response formatting
- Webhook queue system
- Logging and retry mechanism
- Developer documentation site

**Pricing Tier:** Basic ($99/mo) - Limited API calls, Pro ($299/mo) - Higher limits, Enterprise - Unlimited

**Estimated Effort:** 2-3 weeks

---

### Pre-built Integration Marketplace

**Business Value:**
- One-click integrations = easier onboarding
- Competitive advantage over fragmented tools
- Network effects (more integrations = more customers)

**Priority Integrations:**

**Tier 1 (Must-Have) - Per Gemini's Recommendation:**
- **Zapier** 🏆 - PRIORITY #1: Force multiplier connecting to 5000+ apps instantly
- **Slack** - Notifications, ticket creation via slash command, real-time chat integration
- **Microsoft Teams** - Same as Slack for Microsoft-focused customers
- **Advanced Email Integration** - Robust inbound parsing (help@customer.com → auto-create tickets)

**Tier 2 (High-Value):**
- **Jira** - Escalate tickets to engineering
- **GitHub** - Link tickets to code issues
- **Stripe** - Billing events (already integrated)
- **Google Workspace** - SSO, Calendar, Drive attachments

**Tier 3 (Nice-to-Have):**
- **Asana/Monday.com** - Project management
- **Salesforce** - CRM sync
- **HubSpot** - Marketing automation
- **Zendesk** - Migration path for existing customers

**Technical Implementation:**
- **Zapier:** Webhooks + REST API (they handle the hard part)
- **Slack/Teams:** OAuth 2.0, slash commands, interactive messages
- **Email:** SendGrid Inbound Parse or Postmark webhooks
- Configuration UI per integration
- Integration status monitoring

**Why Zapier First (Gemini's Insight):**
- Lowest implementation cost for maximum customer value
- Customers get access to 5000+ apps without us building each one
- Broadest impact across diverse customer tools
- Natural gateway drug to paid plans ("I need more Zaps")

**Pricing Model:**
- Basic integrations (Slack, Email) - All plans
- Premium integrations - Pro and above
- Enterprise integrations (Salesforce) - Enterprise only

**Estimated Effort:** 1 week per integration

---

### Directory Services Integration

**Business Value:**
- Automatic user provisioning/deprovisioning
- Single source of truth for user directory
- Reduced administrative burden

**Integrations:**
- **LDAP/Active Directory** - On-premise directory
- **Azure AD** - Cloud directory (already planned for SSO)
- **Google Workspace** - Directory API
- **Okta** - Universal Directory

**Features:**
- Automated user sync (hourly, daily, real-time)
- Group-based role mapping
- Automatic deactivation when removed from directory
- Profile photo sync
- Department/location sync

**Technical Implementation:**
- LDAP client for AD sync
- Azure AD Graph API
- Google Directory API
- Webhook receivers for real-time updates

**Pricing Tier:** Enterprise ($499/mo)

**Estimated Effort:** 2-3 weeks

---

## Pillar 3: Administration and Control

### Team & Department Management

**Business Value:**
- Organize large user bases
- Department-specific dashboards
- Manager visibility into team performance

**Features:**

**Hierarchical Structure:**
```
Company (Tenant)
└── Departments
    └── Teams
        └── Users
```

**Department Features:**
- Department manager role
- Department-specific ticket queues
- Department performance metrics
- Budget tracking per department

**Database Schema:**
```php
// Create departments table
Schema::create('departments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->foreignId('manager_id')->nullable()->constrained('users');
    $table->text('description')->nullable();
    $table->timestamps();
});

// Add to users table
$table->foreignId('department_id')->nullable()->constrained();
$table->foreignId('team_id')->nullable()->constrained();
```

**Technical Implementation:**
- Filament resources for management
- Scoped queries based on department
- Department-specific dashboards
- Manager permission level

**Pricing Tier:** Pro ($299/mo)

**Estimated Effort:** 1-2 weeks

---

### IP Whitelisting

**Business Value:**
- Security requirement for enterprises
- Prevent unauthorized access
- Compliance requirement

**Features:**
- Allow/deny IP ranges
- Per-tenant configuration
- Bypass for specific users (remote workers)
- Audit log of access attempts
- Emergency bypass option

**Database Schema:**
```php
Schema::create('ip_whitelist', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
    $table->string('ip_address'); // Supports CIDR notation
    $table->string('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

**Technical Implementation:**
- Middleware to check IP against whitelist
- Filament interface for management
- Support CIDR notation (192.168.1.0/24)
- Cloudflare integration (trusted proxy IPs)

**Pricing Tier:** Enterprise ($499/mo)

**Estimated Effort:** 3-5 days

---

### Sandbox Environments

**Business Value:**
- Test integrations safely
- Train new staff without affecting production
- Try new features before rollout
- Competitive differentiator

**Features:**
- Clone production data to sandbox
- Separate subdomain (sandbox.companyname.cwick.us)
- Data refresh on-demand
- Clearly labeled UI (banner: "SANDBOX ENVIRONMENT")
- Restrictions: No real emails sent, no charges processed

**Technical Implementation:**
- Database cloning script
- Environment flag in tenant record
- Conditional logic for external services
- Separate Stripe test mode keys

**Pricing Tier:** Enterprise ($499/mo)

**Estimated Effort:** 1-2 weeks

---

## Pillar 4: Advanced Reporting & Analytics

### Custom Report Builder

**Business Value:**
- Self-service analytics
- Reduce support requests ("Can you pull this data?")
- Data-driven decision making
- Justifies higher pricing

**Features:**

**Report Types:**
- Ticket volume by category, priority, status
- Average resolution time by assignee
- Asset utilization rates
- Knowledge base views and feedback
- User activity reports
- SLA compliance reports

**Report Builder UI:**
- Drag-and-drop interface
- Select metrics, dimensions, filters
- Date range picker
- Grouping and aggregation
- Save and schedule reports
- Email delivery (daily, weekly, monthly)

**Visualization:**
- Charts: Line, bar, pie, donut
- Tables with sorting and filtering
- Export: CSV, Excel, PDF

**Technical Implementation:**
- Laravel Query Builder for dynamic queries
- Chart.js or ApexCharts for visualization
- PDF generation: DomPDF or Snappy
- Scheduled jobs for email delivery
- Consider package: `spatie/laravel-query-builder`

**Pricing Tier:** Pro ($299/mo) - Limited reports, Enterprise ($499/mo) - Unlimited

**Estimated Effort:** 2-3 weeks

---

### Data Export & BI Tool Integration

**Business Value:**
- Use customer's existing BI tools
- Deep analysis not possible in web UI
- Enterprise requirement

**Features:**

**Bulk Export:**
- Full database export (CSV, JSON, SQL dump)
- Incremental exports (changes since last export)
- Automated daily/weekly exports to S3
- GDPR data portability compliance

**BI Tool Integration:**
- Read-only database replica (PostgreSQL preferred)
- Connect Tableau, Power BI, Looker
- Pre-built dashboard templates
- Data dictionary documentation

**Database Replica:**
- Separate read replica (prevents query load on production)
- Sync every 15-30 minutes
- Restricted to tenant's data only
- Connection credentials managed in admin panel

**Technical Implementation:**
- MySQL read replica setup
- Tenant-specific database views
- S3 export job
- API endpoint for incremental export
- Database connection manager

**Pricing Tier:** Enterprise ($499/mo) - Export only, Enterprise Plus ($999/mo) - Read replica

**Estimated Effort:** 1-2 weeks

---

## Implementation Priority (Post-Revenue)

**Phase 2A - Quick Wins (1-2 months):**
1. **Zapier Integration** 🏆 - Force multiplier (Gemini's #1 priority)
2. Fine-Grained RBAC - High demand, already have foundation
3. Comprehensive Audit Logs - Security selling point
4. Public REST API - Enables custom integrations (foundation for Zapier)

**Phase 2B - Enterprise Essentials (2-4 months):**
5. **Slack & Teams Integration** - Real-time notifications, ticket creation from chat
6. **Advanced Email Parsing** - help@customer.com → auto-create/update tickets
7. SSO (Microsoft/Google) - Required for 100+ employee companies (use package!)
8. Team & Department Management - Organizational scale

**Phase 2C - Premium Features (4-6 months):**
9. Webhooks - Real-time event notifications
10. Custom Report Builder - Self-service analytics
11. Integration Marketplace expansion (Jira, GitHub, Asana)
12. IP Whitelisting - Security hardening
13. Sandbox Environments - Training and testing
14. Data Export & BI Integration - Analytics power users

**Phase 3 - Compliance (6-12+ months, at $20-30k MRR):**
15. SOC 2 Type II - Enterprise requirement ($15-50k investment)
16. HIPAA (if healthcare customers emerge)
17. ISO 27001 - Global enterprises

---

## Revenue Impact Projections

**Current Pricing (MVP):**
- Free: Internal/beta customers
- Basic: $99/mo - Core features
- Pro: $299/mo - Advanced features
- Enterprise: $499/mo - White-glove support

**With Enterprise Features:**
- Free: (eliminated or very limited trial)
- Starter: $99/mo - Basic features, 10 users
- Professional: $299/mo - Advanced features, SSO, API, 50 users
- Enterprise: $799/mo - Full features, audit logs, 200 users
- Enterprise Plus: $1,499/mo - Compliance, read replica, unlimited users

**Customer Acquisition:**
- 10 customers at $99/mo = $990/mo
- 5 customers at $299/mo = $1,495/mo
- 2 customers at $799/mo = $1,598/mo
- 1 customer at $1,499/mo = $1,499/mo
- **Total MRR: $5,582/mo ($66,984/year)**

**Key Insight:** One enterprise customer ($799-1499/mo) = 8-15 basic customers. Focus on enterprise features once we prove product-market fit.

---

## Architecture Considerations (Build Now, Use Later)

**These decisions affect architecture TODAY:**

1. **Multi-tenant from day one** ✅ - Already implemented
2. **Audit trail infrastructure** ✅ - LogsActivity trait exists
3. **Permission system** ✅ - Spatie Permission installed
4. **API-first design** - Build admin features as API + UI
5. **Separate tenant config** ✅ - Settings JSON column exists
6. **Event-driven architecture** - Use Laravel Events for webhook foundation
7. **Queue all heavy operations** - Prevents timeout issues at scale

**Don't Over-Engineer:**
- Start with single database, tenant_id scoping ✅
- Can migrate to separate DBs per tenant later if needed
- Use SaaS services (SendGrid, S3) instead of self-hosting
- Cloudflare for DDoS protection, not custom solution

---

## Success Metrics

**Phase 1 (MVP - Current):**
- 10 paying customers
- $2,000 MRR
- 90% customer satisfaction
- Dog-fooding at Danielle Fence successfully

**Phase 2 (Enterprise Features):**
- 30 paying customers
- $10,000 MRR
- 2-3 enterprise customers ($799/mo+)
- SSO, API, RBAC implemented

**Phase 3 (Compliance):**
- 100 paying customers
- $50,000 MRR
- SOC 2 certified
- 10+ enterprise customers
- Team of 3-5 employees

---

## Gemini's Recommendations - Integrated ✅

All of Gemini's suggestions have been incorporated into this roadmap:

- ✅ **Pillar 1: Security & Compliance** - SSO, RBAC, Audit Logs, Certifications
- ✅ **Pillar 2: Integrations** - API, Webhooks, Marketplace, Directory Services
- ✅ **Pillar 3: Administration** - Teams, IP Whitelisting, Sandbox
- ✅ **Pillar 4: Reporting** - Custom Reports, Data Export, BI Integration

**Strategic Alignment:**
- These features are correctly deferred post-revenue
- They inform architectural decisions being made today
- They provide a clear upgrade path for growing customers
- They justify premium pricing tiers

---

## Gemini's Strategic Feedback (2025-11-23) ✅

### Integration Priority: **Zapier First**
> "This is a force multiplier. By integrating with Zapier, you instantly connect to thousands of other apps without building direct integrations, unlocking immense value for a diverse customer base with varied tools."

**Updated Priority:**
1. Zapier (lowest implementation cost, maximum customer value)
2. Slack/Teams (real-time communication efficiency)
3. Advanced email parsing (fundamental for helpdesk)

### SSO: **Use Package, Not Custom**
> "Building custom SSO is a highly complex, security-critical task with significant ongoing maintenance and potential for vulnerabilities. Packages like `aacotroneo/laravel-saml2` abstract away much of this complexity."

**Decision:** Use well-maintained packages for all SSO implementations.

### API: **REST for V1**
> "REST offers simplicity, widespread understanding, and broad compatibility, which is ideal for empowering small businesses to integrate with basic scripts or Zapier. GraphQL could be considered as an additional API layer later."

**Decision:** REST API for initial release, GraphQL deferred for future power users if needed.

### Compliance: **$20-30k MRR Threshold**
> "This level of recurring revenue indicates a validated product-market fit and sufficient financial stability to absorb the cost and ongoing operational overhead required for compliance."

**Decision:** Defer SOC 2 certification until $20-30k MRR achieved.

---

**Last Updated:** 2025-11-23 by Vision (Claude Code) + Gemini Strategic Input
**Next Review:** After first 10 paying customers
