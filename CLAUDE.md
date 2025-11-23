# CwickDesk - Project Documentation

**Created:** 2025-11-22
**Product Name:** CwickDesk
**Local URL:** https://it.test
**Purpose:** All-in-one IT management platform for SMBs and MSPs

---

## Project Genesis

### The SaaS Discovery Conversation

During a discussion about the fence calculator project (calculator.daniellehub.com), Shane realized that building quality software quickly together could unlock SaaS opportunities beyond construction/trades.

**Key insight:** "We built the fence calculator in just a few hours - what other companies need SaaS software that we could build together?"

Vision suggested exploring various industries, but Shane identified the REAL problem he's been living with for years:

> "One thing I've been trying to build since I started with Danielle Fence is a one-stop IT management suite. Even the IT company that we outsource our work to uses many different softwares to keep track of our information."

### The Fragmentation Problem

**Current setup at Danielle Fence:**
- **Snipe-IT** for asset management (modified with custom features)
- **Custom phone list** at phonelist.daniellehub.com (standalone PHP app)
- **Missing:** Ticketing system, documentation/wiki, time tracking, many other features

**The upgrade trap:**
- Shane added custom features to Snipe-IT (accounts table, phone fields, wiki tables)
- Every Snipe-IT upgrade wipes his customizations
- Forced to choose: stay outdated OR lose custom work

**Shane's exact words:**
> "I've added some of this functionality to it, but if I ever want to upgrade snipe-it, all of my work will be gone."

---

## Market Research (Nov 22, 2025)

### Current Enterprise Solutions

**Major Players:**
- ConnectWise PSA (Manage + Automate)
- Datto Autotask PSA
- ServiceNow
- BMC Helix
- Ivanti

**Common complaints:**
- Extremely expensive (no public pricing = very expensive)
- Steep learning curve (ConnectWise notorious for this)
- Complex implementation
- Per-user pricing adds up fast
- Enterprise-level overkill for SMBs
- Integration hell (250+ integrations needed)

### Pain Points for SMBs

**Cost Issues:**
- High upfront and ongoing costs
- Hidden fees (implementation, training, integrations)
- Per-user pricing doesn't scale for small teams
- MSPs charge less than buying enterprise tools

**Complexity:**
- Difficult onboarding for new technicians
- Outdated, not user-friendly interfaces
- Built for ITIL-certified teams, not lean IT departments
- "ServiceNow-level teams with massive budgets and dedicated admins"

**Fragmentation:**
- Separate tools for ticketing, assets, passwords, documentation
- Everything ends with "export to Excel and manually combine"
- Context switching kills productivity

### 2025 Trends

**AI Automation:**
- 2025 called "the year of Agentic AI"
- Best systems auto-resolve 60%+ of tickets without human agents
- Operating inside Microsoft Teams/Slack
- Predictive maintenance (fix before users complain)

**SMB-Focused Platforms:**
- Faster deployment (under 1 week vs months)
- Flat-rate pricing instead of per-user
- Built-in automation for lean teams
- Cloud-based to eliminate infrastructure costs

---

## What IT Managers Need Daily

### Core Features (PSA - Professional Services Automation)

#### 1. Service Desk / Ticketing
- Multi-channel ticket creation (email, phone, web form, chat)
- AI-powered auto-categorization and routing
- SLA tracking with alerts
- Automated ticket summaries (new in 2025)
- Priority/urgency matrix
- Ticket templates for common issues
- Visual performance metrics

#### 2. Asset Management
- Hardware/software inventory tracking
- Automated alerts for failing hardware
- Warranty expiration tracking
- Asset lifecycle (purchase → deployment → retirement)
- Real-time data feeding into help desk
- QR code/barcode labeling
- Asset-to-ticket linking

#### 3. Password & Credential Management
- AES 256-bit encryption with zero-knowledge architecture
- Role-based access controls (RBAC)
- Activity logs (who accessed what and when)
- Secure group sharing
- Emergency access for super admins
- Password expiration reminders
- Audit trails for compliance

#### 4. Knowledge Base / Documentation
- Central hub for SOPs, onboarding, FAQs
- Searchable articles
- Version control
- Rich text editor with screenshots
- Internal wiki for IT procedures
- Ticket-to-article linking

#### 5. Time Tracking & Billing
- Time entries linked to tickets
- Billable vs non-billable hours
- Client invoicing automation
- Project time tracking

#### 6. Reporting & Analytics
- Ticket volume trends
- Average resolution time
- SLA compliance reports
- Asset utilization reports
- Technician performance metrics

---

## Shane's Current Custom Implementations

### 1. Snipe-IT Modifications (it.daniellefence.net)

**Custom migrations created:**

**User Extensions (2025-05-13):**
```php
// Plain text password storage for super admin visibility
$table->string('plain_text_password')->nullable();

// Phone list fields
$table->string('extension')->nullable();
$table->string('cell')->nullable();
$table->string('direct')->nullable();
$table->string('building')->nullable();
$table->string('department')->nullable();
$table->string('area_of_responsibility')->nullable();
```

**Accounts Table:**
```php
// Company account logins (Facebook, etc.)
id, name, url, username, password, created_at, updated_at
```

**Wiki System (incomplete):**
```php
// Started but abandoned - tables created but wiki has no fields
wikicategories, wikisubcategories, wikis
```

**Custom Livewire Components:**
- `Accounts.php` - Full CRUD for company accounts
- `AccountEdit.php` - Edit account credentials
- `PhoneList.php` - Employee directory
- `Wiki.php` - Documentation (incomplete)

### 2. Phone List App (phonelist.daniellehub.com)

**Architecture:**
- Standalone PHP file (18KB)
- Pulls data from Snipe-IT via encrypted API
- AES-256-CBC encryption with shared key
- Login with Snipe-IT credentials

**Features:**
- Smart column visibility (only shows columns with data)
- Two-section layout (Internal with extensions / Outside numbers)
- Print-optimized CSS (11" x 8.5" landscape)
- Clickable tel: and mailto: links
- Phone number formatting
- Sortable columns (click headers)
- Session management
- Company branding

**Encrypted API endpoint:**
```php
// at it.daniellehub.com/useroutput/{authKey}
// Returns AES-256-CBC encrypted JSON with IV
```

**This demonstrates:**
- Shane can build purpose-built interfaces
- Encryption/security knowledge
- Understanding of separation of concerns
- API-first architecture thinking

---

## Shane's Vision: Microservices Architecture

**Core insight from phone list implementation:**

Shane didn't build a monolithic phone list inside Snipe-IT. He built:
1. **Core backend** (Snipe-IT) - stores data, provides encrypted APIs
2. **Specialized app** (phone list) - lightweight, purpose-built, optimized for printing

**This pattern could scale:**

**Core Laravel Backend:**
- User management
- Asset management
- Account/password storage
- Ticketing system
- Documentation/wiki
- Provides encrypted REST APIs

**Specialized Mini-Apps:**
- Phone list (already exists)
- Printable asset labels
- Quick ticket submission
- Password lookup portal
- Mobile-optimized interfaces

**Advantages:**
- Each app purpose-built for specific workflow
- Deploy independently
- No context switching
- Optimize each for its use case

---

## The SaaS Opportunity

### Market Validation

**Pricing research:**
- ConnectWise & Autotask: No public pricing (sign of high cost)
- Enterprise tools: $50-150/user/month
- SMBs complain about cost and complexity

**Target market:**
- 10-50 employee companies
- 1-3 IT staff members
- Currently using fragmented tools OR paying MSPs
- Need enterprise features without enterprise complexity

**Competitive advantage:**
- Shane LIVES this problem daily at Danielle Fence
- Knows what's overkill vs actually needed
- Proven ability to build features quickly (fence calculator in hours)
- Laravel + Filament = rapid MVP development

**Potential pricing:**
- Flat rate: $99-299/month (unlimited users)
- Undercut per-user pricing dramatically
- Target small businesses avoiding enterprise costs

### Development Strategy

**Phase 1: Build for Danielle Fence**
- Solve Shane's own IT management needs
- Replace Snipe-IT + fragmented tools
- Dog-food the product daily
- Iterate based on real usage

**Phase 2: Package as SaaS**
- Multi-tenancy
- Company-specific pricing tables
- Branding customization
- Subscription/billing
- Company user management

**Phase 3: Market to SMBs/MSPs**
- Position as "enterprise features, SMB pricing"
- Target companies escaping expensive tools
- Offer migration from ConnectWise/Autotask
- Highlight simplicity and fast onboarding

---

## MVP Feature Priority

### Must-Have (Phase 1)

**1. Ticketing System** (highest priority - Shane doesn't have this)
- Email-to-ticket
- Web form submission
- SLA tracking
- Assignee management
- Status workflow
- Internal notes vs customer-facing updates

**2. Enhanced Asset Management** (build on Snipe-IT's strengths)
- Asset-to-ticket linking
- Warranty alerts
- Lifecycle tracking
- QR code labeling
- Custom fields

**3. Password Manager** (Shane has basic version - make enterprise-grade)
- Role-based access
- Audit logs
- Emergency super admin access
- Password expiration
- Secure sharing

**4. Knowledge Base** (Shane started this in Snipe-IT)
- Searchable articles
- Categories and tags
- Rich text editor
- Ticket-to-article linking
- Version history

**5. Reporting Dashboard** (ties it all together)
- Ticket metrics
- Asset overview
- SLA compliance
- Technician performance

### Nice-to-Have (Phase 2+)
- Time tracking & billing
- Client portal
- Mobile app
- Integrations (email, Slack, Teams)
- Remote monitoring alerts
- Automated workflows
- AI-powered ticket routing
- Predictive maintenance

---

## Technical Stack (Proposed)

**Backend:**
- Laravel 12 (latest)
- Filament 4.2.2 (admin panel like calculator project)
- PostgreSQL or MySQL
- Redis (caching, queues)
- Laravel Sanctum (API authentication)

**Frontend:**
- Filament admin interface (rapid development)
- Alpine.js (lightweight interactions)
- Livewire (real-time updates)
- Tailwind CSS v4

**Infrastructure:**
- Start local (it.test)
- Production: DigitalOcean or similar
- Multi-tenant database architecture
- S3 for file storage
- Queue workers for async tasks

**Security:**
- AES-256 encryption for passwords
- Two-factor authentication
- Role-based permissions
- Audit logging
- Regular backups
- SSL everywhere

---

## Success Metrics

**Internal (Danielle Fence):**
- Replace all Snipe-IT functionality
- Eliminate need for separate tools
- Reduce time spent managing IT by 50%
- All IT staff using it daily within 2 weeks

**SaaS Launch:**
- 10 paying customers in first 3 months
- Average $199/month pricing
- 90% customer satisfaction
- <5 minute onboarding time
- Positive cash flow within 6 months

---

## Open Questions

1. Multi-tenant architecture: Shared database with tenant_id or separate databases?
2. Ticketing: Email parsing service (SendGrid, Postmark) or custom IMAP?
3. Mobile app: Native or PWA?
4. AI features: OpenAI integration or open-source models?
5. Integrations: Which are must-have vs nice-to-have?

---

## Next Steps

1. ✅ Create fresh Laravel installation (this project)
2. ✅ Document conversation (this file)
3. ⏳ Update Vision vault with project details
4. ⏳ Continue brainstorming features and architecture
5. ⏳ Design database schema
6. ⏳ Build MVP ticketing system
7. ⏳ Migrate Shane's phone list integration
8. ⏳ Replace Snipe-IT completely

---

## Resources & References

**Research Sources:**
- [Datto Autotask vs ConnectWise PSA](https://www.connectwise.com/platform/psa/datto-autotask-vs-connectwise-psa)
- [Best Managed IT Service Software 2025](https://www.atera.com/blog/best-managed-it-service-software/)
- [Top PSA Software for MSPs](https://deskday.com/best-psa-software-for-msps/)
- [Best Help Desk with Asset Management](https://thectoclub.com/tools/best-help-desk-software-with-asset-management/)
- [IT Ticketing Systems Role](https://www.lansweeper.com/blog/itam/the-role-of-ticketing-systems-in-modern-it-service-management/)
- [Small Business IT Pain Points](https://biztechmagazine.com/article/2025/05/6-ways-startups-can-solve-their-most-common-it-pain-points)
- [Password Management for IT Teams](https://teampassword.com/blog/password-management-software-it-msp)
- [Knowledge Base Features](https://perfectwikiforteams.com/blog/how-to-set-up-knowledgbase-ms-teams/)

**Existing Implementations:**
- Snipe-IT instance: it.daniellefence.net (server: 138.197.32.98:/home/it/public_html/)
- Phone list: phonelist.daniellehub.com (server: 138.197.32.98:/home/phonelist/public_html/)
- Fence calculator (reference): calculator.daniellehub.com

---

*This project represents the convergence of Shane's lived experience with IT management pain and Vision's rapid development capabilities. Together, we're building what enterprise vendors overcomplicated and overpriced.*

---

## SSO Integration (Added Nov 22, 2025)

### Microsoft Office 365 / Entra ID (Azure AD)

**Why this is critical:**
- Most SMBs already use Microsoft 365
- Eliminates separate password management for the IT suite
- Seamless onboarding: "Sign in with Microsoft" button
- Automatic user directory sync
- Enterprise-grade security without enterprise complexity

**Implementation:**
- OAuth 2.0 / OpenID Connect
- Laravel Socialite with Microsoft provider
- Role mapping from Microsoft groups to IT suite roles

**User Experience:**
1. User clicks "Sign in with Microsoft"
2. Redirects to Microsoft login
3. User authenticates with work account
4. Redirected back to IT suite (authenticated)
5. User profile auto-populated from Microsoft directory

**Technical Benefits:**
- Single source of truth for user directory
- Automatic provisioning/deprovisioning
- Multi-factor authentication (if enabled in Microsoft)
- Conditional access policies respected
- Audit trail through Microsoft logs

**Competitive Advantage:**
- Enterprise feature that SMBs actually use daily
- Reduces support burden (no "forgot password" tickets)
- Increases adoption (no new credentials to remember)
- Makes switching from enterprise tools easier

**Future SSO Providers:**
- Google Workspace (second priority)
- Okta / OneLogin (for larger SMBs)
- Generic SAML 2.0 support

**Database Impact:**
```php
// Users table additions
$table->string('sso_provider')->nullable(); // 'microsoft', 'google', etc.
$table->string('sso_id')->nullable(); // External user ID
$table->json('sso_data')->nullable(); // Store profile data
$table->timestamp('last_sso_sync')->nullable();
```

**Shane's Use Case:**
- Danielle Fence likely uses Office 365
- All employees can sign in with existing @daniellefence.net accounts
- No separate password management needed
- Automatic sync when employees are added/removed in Microsoft

---

## Ownership & IP Structure (Nov 22, 2025)

### Business Model Clarification

**Ownership:**
- Shane builds this **off the clock** on personal time
- Shane **owns** the intellectual property and codebase
- This is Shane's SaaS product, NOT Danielle Fence property

**Usage at Danielle Fence:**
- Danielle Fence will be a **customer** (possibly free/discounted as beta)
- Perfect dog-fooding: Shane uses his own product daily at work
- Real-world testing and feedback from actual users
- Proves product value before selling to other SMBs

**Why this works:**
- Built on personal time with personal resources
- Solves a general problem (not Danielle Fence-specific)
- Benefits many companies (general-purpose IT management)
- Common SaaS founder strategy

**Similar successful examples:**
- Basecamp (37signals built it for their own use, then sold it)
- GitHub (built for developers, by developers)
- Slack (internal tool that became massive SaaS)

### Microsoft 365 Tenant Access Requirement

**Needed for development:**
- Admin access to Microsoft 365 tenant (to register app)
- Required for Office 365 SSO integration
- Shane will request access for "multiple projects"

**Development approach without immediate access:**
1. Build SSO infrastructure with mock provider
2. Design OAuth flow and database schema
3. Test with GitHub/Google OAuth (similar flow)
4. Switch to Microsoft once tenant access obtained

**App Registration requirements (when ready):**
- Azure AD app registration
- Redirect URIs configured
- API permissions: User.Read, email, profile, openid
- Client ID and Client Secret
- Tenant ID

### Multi-Tenant Considerations for SaaS

**Each customer company:**
- Registers their own Microsoft app (or we provide instructions)
- Configures their tenant ID in our platform
- Their employees SSO with their own Office 365 accounts

**OR (easier for customers):**
- We create multi-tenant Azure AD app
- Customers just approve permissions for their tenant
- No technical setup required from customers
- Better SaaS experience

**This is how Slack, Zoom, etc. do it.**

---

## Authentication Migration Strategy (Nov 22, 2025)

### Phase 1: Password Authentication (Immediate)

**Current situation:**
- Shane has employee passwords in Excel sheet
- Can import users immediately
- Start using the system right away at Danielle Fence

**Implementation:**
```php
// User import from Excel
- Read Excel file with user data
- Hash passwords (bcrypt) - NEVER store plain text
- Create user accounts
- Send welcome emails (optional)
```

**User table structure:**
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password')->nullable(); // Nullable for SSO-only users later
    
    // SSO fields (prepared but not used yet)
    $table->string('sso_provider')->nullable(); // 'microsoft', 'google', etc.
    $table->string('sso_id')->nullable();
    $table->json('sso_data')->nullable();
    $table->timestamp('last_sso_sync')->nullable();
    
    // Phone list fields (from Snipe-IT)
    $table->string('extension')->nullable();
    $table->string('cell')->nullable();
    $table->string('direct')->nullable();
    $table->string('building')->nullable();
    $table->string('department')->nullable();
    $table->string('area_of_responsibility')->nullable();
    
    $table->rememberToken();
    $table->timestamps();
});
```

### Phase 2: Dual Authentication (Transition Period)

**When Microsoft tenant access obtained:**
- Keep password authentication working
- Add "Sign in with Microsoft" button
- Users can choose either method
- Encourage migration to SSO

**User experience:**
```
Login page:
┌─────────────────────────────┐
│ Email: [____________]       │
│ Password: [____________]    │
│ [Login]                     │
│                             │
│ ────── OR ──────           │
│                             │
│ [Sign in with Microsoft]    │
└─────────────────────────────┘
```

### Phase 3: SSO-Only (Future)

**After all users migrated:**
- Disable password authentication (optional)
- SSO becomes primary auth method
- Legacy passwords can be cleared
- Fully managed by Microsoft

**Benefits of this approach:**
1. ✅ Start using immediately with existing passwords
2. ✅ No dependency on Microsoft tenant access
3. ✅ Smooth migration path when ready
4. ✅ Users control their own migration timeline
5. ✅ No service interruption during SSO implementation

### Excel Import Feature

**Required fields in Excel:**
- Name
- Email
- Password (will be hashed on import)
- Extension (optional)
- Cell (optional)
- Department (optional)
- Location (optional)

**Import process:**
1. Upload Excel file via admin panel
2. Validate data (check for duplicates, required fields)
3. Preview import (show what will be created)
4. Confirm and import
5. Hash passwords securely (bcrypt)
6. Send welcome emails with login instructions

**Future enhancement:**
- Bulk user management (create/update/delete)
- CSV export
- Sync with Microsoft directory when SSO enabled

---

## Enterprise-Grade Roadmap (Nov 23, 2025)

### Gemini's Strategic Input - Integrated

Gemini provided comprehensive guidance on building toward an enterprise-grade product while maintaining revenue velocity. Full details in `ENTERPRISE_ROADMAP.md` and coordination in `PROJECT_STATUS.md`.

**Core Principle:** Build for enterprise-scale from day one, but defer enterprise features until post-revenue.

### Four Pillars to Enterprise-Grade

**Pillar 1: Advanced Security & Compliance**
- SSO (SAML 2.0, OIDC) - Microsoft, Google, Okta integration
- Fine-grained RBAC - Custom roles with granular permissions
- Comprehensive audit logs - Immutable, exportable, searchable
- Compliance certifications - SOC 2 Type II, ISO 27001, HIPAA

**Pillar 2: Deep Integration Capabilities**
- Public API & Webhooks - REST API, real-time events
- Pre-built Integration Marketplace - Slack, Teams, Jira, Zapier
- Directory Services - LDAP, Azure AD sync
- Automated provisioning/deprovisioning

**Pillar 3: Administration and Control**
- Team & Department Management - Hierarchical structure
- IP Whitelisting - Security requirement for enterprises
- Sandbox Environments - Testing without affecting production
- Multi-level access controls

**Pillar 4: Advanced Reporting & Analytics**
- Custom Report Builder - Self-service analytics
- Data Export & BI Tool Integration - Tableau, Power BI
- Read-only database replicas for enterprise customers
- Scheduled report delivery

### Implementation Priority (Post-Revenue)

**Phase 2A - Quick Wins (1-2 months):**
1. Fine-Grained RBAC (foundation already exists)
2. Comprehensive Audit Logs (LogsActivity trait exists)
3. Public API (enables custom integrations)
4. Slack Integration (most requested)

**Phase 2B - Enterprise Essentials (2-4 months):**
5. SSO (Microsoft/Google)
6. Team & Department Management
7. Webhooks
8. Custom Report Builder

**Phase 2C - Premium Features (4-6 months):**
9. IP Whitelisting
10. Integration Marketplace (Jira, GitHub, Zapier)
11. Sandbox Environments
12. BI Tool Integration

**Phase 3 - Compliance (6-12+ months):**
13. SOC 2 Type II ($15-50k investment)
14. HIPAA (if healthcare customers emerge)
15. ISO 27001 (global enterprises)

### Revenue Impact

**Current Pricing (MVP):**
- Basic: $99/mo - Core features, 10 users
- Pro: $299/mo - Advanced features, 50 users
- Enterprise: $499/mo - Full features, 200 users

**With Enterprise Features:**
- Starter: $99/mo - Basic features
- Professional: $299/mo - SSO, API, Advanced RBAC
- Enterprise: $799/mo - Full features, Audit logs, Compliance
- Enterprise Plus: $1,499/mo - Dedicated replica, Unlimited users

**Key Insight:** One enterprise customer ($799-1,499/mo) = 8-15 basic customers. This justifies investing in enterprise features once we prove product-market fit.

### Architectural Decisions That Affect Us TODAY

**Built Now (Foundation):**
- ✅ Multi-tenant architecture (domain-based)
- ✅ Permission system (Spatie Permission)
- ✅ Audit trail infrastructure (LogsActivity trait)
- ✅ Tenant configuration (settings JSON column)

**Build With This In Mind:**
- Event-driven architecture (use Laravel Events for webhook foundation)
- API-first design (build admin features as API + UI)
- Queue all heavy operations (prevents timeout issues at scale)

**Don't Over-Engineer:**
- Single database with tenant_id scoping (can migrate to separate DBs later)
- Use SaaS services (SendGrid, S3) instead of self-hosting
- Cloudflare for DDoS, not custom solution

### Vision & Gemini Collaboration

Communication happens in `PROJECT_STATUS.md` for:
- Feature completion updates
- Architectural decision documentation
- Questions and strategic discussion
- Technical debt tracking

**Current Questions for Gemini:**
1. Integration priority - Slack, Teams, Email, Zapier as Tier 1?
2. SSO implementation - Package vs custom?
3. API design - REST vs GraphQL?
4. Compliance timeline - What MRR threshold for SOC 2 investment?

**Current Questions for Shane:**
1. Does Danielle Fence use Office 365 for all employee accounts?
2. Which integrations would Danielle Fence actually use?
3. How is Danielle Fence organized (departments, teams, locations)?

---

## Multi-Tenant Architecture (Nov 23, 2025)

### Implementation Complete ✅

**Domain-Based Routing:**
- it.daniellehub.com → Danielle Fence tenant (internal, free)
- *.cwick.us → Commercial tenants (paid subscriptions)
- cwick.us → Landing page, pricing, signup

**Configuration:**
- `DomainTenantFinder` - Automatic tenant detection from request domain
- `PrefixCacheTask` - Separate cache per tenant
- Middleware: `NeedsTenant` + `EnsureValidTenantSession`
- Database: Single database (`it_landlord`) with `tenant_id` scoping

**Dual-Mode System:**
```php
// Tenant model methods
isInternal() → true for Danielle Fence
requiresBilling() → false for internal tenants
shouldShowBillingUI() → hide billing UI for internal tenants
```

**Initial Setup:**
- Tenant #1: Danielle Fence (it.daniellehub.com, enterprise plan, internal)
- User: sbarron@daniellefence.net (super_admin, admin roles)
- Platform Admin: mrshanebarron@gmail.com (platform_admin role, no tenant)

**Database Structure:**
- Landlord database: `it_landlord` (tenants, users, subscriptions)
- All data tables have `tenant_id` foreign key
- `BelongsToTenant` trait on all models for automatic scoping
- Spatie Permission for role/permission management

**How It Works:**
1. Request comes to `it.daniellehub.com`
2. `DomainTenantFinder` queries: `SELECT * FROM tenants WHERE domain = 'it.daniellehub.com'`
3. Matched tenant becomes "current tenant" for request
4. All queries automatically scoped to `tenant_id = 1`
5. Cache keys prefixed with tenant ID

**Future Migration Path:**
- When needed (50+ tenants or enterprise demand), can migrate to separate databases per tenant
- Spatie's `SwitchTenantDatabaseTask` makes this straightforward
- Can offer "dedicated database" as premium feature

### Testing Locally

Add to `/etc/hosts`:
```
127.0.0.1 it.daniellehub.com
127.0.0.1 cwick.us
```

Access: https://it.daniellehub.com (with local development server)
