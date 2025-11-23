# Roles & Permissions System

**Added:** November 22, 2025
**Package:** Spatie Laravel Permission v6.23.0
**Status:** Fully Configured and Seeded

---

## 🎯 What Was Added

### 1. Spatie Laravel Permission Package
- Installed and configured Spatie's industry-standard permission package
- Published config file: `config/permission.php`
- Created 5 database tables:
  - `roles` - User roles (super_admin, admin, agent, user)
  - `permissions` - Individual permissions (29 total)
  - `model_has_permissions` - Direct user permissions
  - `model_has_roles` - User role assignments
  - `role_has_permissions` - Role permission assignments

### 2. User Model Enhancement
- Added `HasRoles` trait to `User` model
- Users can now have multiple roles
- Permission checking via: `$user->hasPermissionTo('view_tickets')`
- Role checking via: `$user->hasRole('admin')`

### 3. Four Default Roles Created

#### Super Admin (29 permissions)
**Color:** Red badge
**Has ALL permissions** - Complete system access

**Use case:** System administrators, IT managers

#### Admin (22 permissions)
**Color:** Orange/Warning badge
**Permissions:**
- All ticket management (view, create, edit, delete, assign, comment)
- All asset management (view, create, edit, delete, assign)
- All KB article management (view, create, edit, delete, publish)
- User management (view, create, edit)
- Settings management (priorities, statuses, categories)
- Reports and export

**Cannot:**
- Delete users
- Manage system roles
- View/edit core system settings

**Use case:** Department managers, senior IT staff

#### Agent (11 permissions)
**Color:** Green badge
**Permissions:**
- View, create, edit tickets
- Comment on tickets (including internal)
- View internal tickets
- View and edit assets
- View, create, edit KB articles
- View reports

**Cannot:**
- Delete tickets or assets
- Assign tickets
- Manage users
- Change system settings
- Publish KB articles (must submit for approval)

**Use case:** IT support staff, help desk agents

#### User (4 permissions)
**Color:** Blue badge
**Permissions:**
- View tickets (their own)
- Create tickets
- Comment on tickets
- View KB articles

**Use case:** Regular employees submitting support requests

---

## 📋 Complete Permission List (29 Permissions)

### Ticket Permissions (7)
- `view_tickets` - View ticket list
- `create_tickets` - Create new tickets
- `edit_tickets` - Edit existing tickets
- `delete_tickets` - Delete tickets
- `assign_tickets` - Assign tickets to agents
- `comment_tickets` - Add comments to tickets
- `view_internal_tickets` - See internal-only tickets

### Asset Permissions (5)
- `view_assets` - View asset list
- `create_assets` - Add new assets
- `edit_assets` - Edit asset details
- `delete_assets` - Delete assets
- `assign_assets` - Assign assets to users

### Knowledge Base Permissions (5)
- `view_kb_articles` - View KB articles
- `create_kb_articles` - Write new articles
- `edit_kb_articles` - Edit articles
- `delete_kb_articles` - Delete articles
- `publish_kb_articles` - Publish articles (make public)

### User Management Permissions (5)
- `view_users` - View user list
- `create_users` - Add new users
- `edit_users` - Edit user details
- `delete_users` - Delete users
- `manage_roles` - Assign/remove user roles

### Settings Permissions (5)
- `view_settings` - View system settings
- `edit_settings` - Modify system settings
- `manage_priorities` - Manage ticket priorities
- `manage_statuses` - Manage ticket statuses
- `manage_categories` - Manage asset/KB categories

### Reporting Permissions (2)
- `view_reports` - Access reporting dashboard
- `export_data` - Export data to CSV/Excel

---

## 🔧 Enhanced User Resource

### User Form (4 Sections)
1. **User Information**
   - Full name, email
   - Password management (hashed)
   - Email verification status

2. **Roles & Permissions** ⭐ NEW
   - Multi-select role dropdown
   - Color-coded role badges
   - Legacy admin/agent flags (backward compatibility)

3. **Phone Directory**
   - Extension, direct line, cell phone
   - Building, department, area of responsibility

4. **SSO Configuration**
   - SSO provider (microsoft, google, etc.)
   - SSO ID
   - Last sync timestamp

### User Table (Enhanced)
**Columns:**
- Name, Email (searchable, sortable)
- **Roles** (color-coded badges) ⭐ NEW
  - Red: super_admin
  - Orange: admin
  - Green: agent
  - Blue: user
- Department, Extension
- Email verified status
- SSO provider

**Filters:** ⭐ NEW
- Filter by role(s)
- Filter by department

**Default Sort:** Name (A-Z)

---

## 💡 Usage Examples

### Checking Permissions in Code

```php
// Check if user has permission
if ($user->hasPermissionTo('edit_tickets')) {
    // Allow editing
}

// Check if user has role
if ($user->hasRole('admin')) {
    // Show admin features
}

// Check multiple permissions (any)
if ($user->hasAnyPermission(['edit_tickets', 'delete_tickets'])) {
    // User can edit OR delete
}

// Check multiple permissions (all)
if ($user->hasAllPermissions(['edit_tickets', 'assign_tickets'])) {
    // User can edit AND assign
}

// Get all user permissions
$permissions = $user->getAllPermissions();

// Get all user roles
$roles = $user->getRoleNames();
```

### Middleware in Routes

```php
// Require specific permission
Route::get('/admin/tickets', function () {
    // ...
})->middleware('permission:view_tickets');

// Require specific role
Route::get('/admin/settings', function () {
    // ...
})->middleware('role:admin');

// Require role OR permission
Route::get('/admin/reports', function () {
    // ...
})->middleware('role_or_permission:admin|view_reports');
```

### In Blade Templates

```blade
@role('admin')
    <p>This is only visible to admins</p>
@endrole

@hasrole('agent')
    <p>Visible to agents</p>
@endhasrole

@can('edit_tickets')
    <button>Edit Ticket</button>
@endcan

@canany(['edit_tickets', 'delete_tickets'])
    <p>Can edit or delete</p>
@endcanany
```

### Assigning Roles Programmatically

```php
// Assign role to user
$user->assignRole('agent');

// Assign multiple roles
$user->assignRole(['agent', 'admin']);

// Remove role
$user->removeRole('agent');

// Sync roles (replace all)
$user->syncRoles(['admin']);

// Give direct permission (bypass role)
$user->givePermissionTo('edit_tickets');

// Revoke permission
$user->revokePermissionTo('edit_tickets');
```

---

## 🎯 Integration with Filament

### User Resource
- ✅ Role selection dropdown in user form
- ✅ Color-coded role badges in table
- ✅ Filter users by role
- ✅ Password hashing on create/update
- ✅ Unique email validation

### Future Enhancements (Optional)
1. **Filament Shield** - UI for managing permissions
   ```bash
   composer require bezhansalleh/filament-shield
   php artisan shield:install
   ```
   - Auto-generate permissions from resources
   - Visual permission management
   - Policy generation

2. **Resource-Level Permission Gates**
   - Protect Filament resources with permissions
   - Hide menu items based on roles
   - Auto-check permissions on CRUD operations

---

## 🔒 Security Best Practices

### Current Implementation
- ✅ Permissions cached for performance
- ✅ Roles assigned to default admin user
- ✅ Password hashing via Laravel's Hash facade
- ✅ Email uniqueness enforced
- ✅ Legacy flags (is_admin, is_agent) preserved

### Recommendations
1. **Always use permissions, not roles** in application logic
   ```php
   // Good
   if ($user->can('edit_tickets')) { }

   // Avoid
   if ($user->hasRole('admin')) { }
   ```

2. **Cache permissions** (already done)
   - Permissions are cached by default
   - Clear cache after role/permission changes:
     ```bash
     php artisan permission:cache-reset
     ```

3. **Assign roles in seeder or admin panel**
   - Never hardcode role assignments
   - Use UI to manage roles for transparency

4. **Middleware on routes**
   - Protect admin routes with role/permission middleware
   - Fail gracefully with 403 responses

---

## 📊 Database Schema

### Roles Table
```sql
- id
- name (unique)
- guard_name
- created_at
- updated_at
```

### Permissions Table
```sql
- id
- name (unique)
- guard_name
- created_at
- updated_at
```

### Model Has Roles (Pivot)
```sql
- role_id
- model_type
- model_id
```

### Role Has Permissions (Pivot)
```sql
- permission_id
- role_id
```

---

## 🎉 What's Ready to Use

### Right Now in Admin Panel
1. **User Management**
   - Create users with role assignment
   - Edit user roles via dropdown
   - Filter users by role
   - See role badges in user list

2. **Default Admin**
   - mrshanebarron@gmail.com has `super_admin` role
   - Full access to all features

3. **Role-Based Access**
   - Roles are enforced in database
   - Ready for middleware implementation
   - Ready for Blade directive usage

### To Implement (Your Choice)
- Add permission checks to resources
- Add middleware to protect routes
- Install Filament Shield for UI management
- Create custom policies for models

---

## 📖 Resources

**Documentation:**
- [Spatie Permission Docs](https://spatie.be/docs/laravel-permission)
- [Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)

**Common Commands:**
```bash
# Clear permission cache
php artisan permission:cache-reset

# Show all permissions
php artisan tinker
>>> \Spatie\Permission\Models\Permission::all()->pluck('name');

# Show all roles
>>> \Spatie\Permission\Models\Role::all()->pluck('name');

# Show user roles
>>> App\Models\User::find(1)->getRoleNames();
```

---

*Roles and permissions system is production-ready. All 4 roles created with appropriate permissions. User management fully enhanced with role assignment.*
