# SSO Setup Guide (Microsoft & Google)

## Overview

This application supports Single Sign-On (SSO) authentication via:
- **Microsoft** (Office 365 / Azure AD / Entra ID)
- **Google** (Google Workspace / Gmail)

## Benefits

- Seamless authentication with existing corporate accounts
- No additional password management
- Automatic user provisioning
- Multi-factor authentication (if enabled on provider)
- Centralized access control

## Microsoft Office 365 / Azure AD Setup

### 1. Register Application in Azure Portal

1. Go to [Azure Portal](https://portal.azure.com)
2. Navigate to **Azure Active Directory** → **App registrations**
3. Click **New registration**
4. Fill in details:
   - **Name**: IT Management Suite (or your app name)
   - **Supported account types**:
     - Single tenant (only your organization)
     - OR Multi-tenant (if offering SaaS to multiple companies)
   - **Redirect URI**: `https://yourdomain.com/auth/microsoft/callback`
5. Click **Register**

### 2. Configure Application

After registration:

1. **Client ID**: Copy the "Application (client) ID"
2. **Tenant ID**: Copy the "Directory (tenant) ID"
3. **Client Secret**:
   - Go to **Certificates & secrets**
   - Click **New client secret**
   - Enter description (e.g., "Production Secret")
   - Choose expiration (recommendation: 24 months)
   - Click **Add**
   - **IMPORTANT**: Copy the secret value immediately (you won't see it again)

4. **API Permissions**:
   - Go to **API permissions**
   - Click **Add a permission**
   - Choose **Microsoft Graph**
   - Select **Delegated permissions**
   - Add these permissions:
     - `User.Read` (read user profile)
     - `email` (read email address)
     - `profile` (read basic profile)
     - `openid` (sign in)
   - Click **Grant admin consent** (if you're admin)

### 3. Add to .env File

Add these values to your `.env` file:

```env
MICROSOFT_CLIENT_ID=your-client-id-here
MICROSOFT_CLIENT_SECRET=your-client-secret-here
MICROSOFT_REDIRECT_URI=https://yourdomain.com/auth/microsoft/callback
MICROSOFT_TENANT_ID=your-tenant-id-here
```

**For multi-tenant apps**, set:
```env
MICROSOFT_TENANT_ID=common
```

### 4. Test

Visit: `https://yourdomain.com/auth/microsoft/redirect`

You should be redirected to Microsoft login, then back to your app after authentication.

---

## Google Workspace / Gmail Setup

### 1. Create Project in Google Cloud Console

1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create a new project (or select existing)
3. Name it (e.g., "IT Management Suite")

### 2. Enable Google+ API

1. Navigate to **APIs & Services** → **Library**
2. Search for "Google+ API"
3. Click **Enable**

### 3. Configure OAuth Consent Screen

1. Go to **APIs & Services** → **OAuth consent screen**
2. Choose user type:
   - **Internal** (only your Google Workspace organization)
   - **External** (anyone with Google account)
3. Fill in app information:
   - **App name**: IT Management Suite
   - **User support email**: your email
   - **Developer contact**: your email
4. **Scopes**: Add these scopes:
   - `userinfo.email`
   - `userinfo.profile`
   - `openid`
5. Save and continue

### 4. Create OAuth Credentials

1. Go to **APIs & Services** → **Credentials**
2. Click **Create Credentials** → **OAuth client ID**
3. Application type: **Web application**
4. Name: IT Management Suite
5. **Authorized redirect URIs**:
   - Add: `https://yourdomain.com/auth/google/callback`
6. Click **Create**
7. **Copy Client ID and Client Secret**

### 5. Add to .env File

```env
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### 6. Test

Visit: `https://yourdomain.com/auth/google/redirect`

You should be redirected to Google login, then back to your app.

---

## User Flow

### New Users

When a user signs in with SSO for the first time:
1. They're redirected to provider (Microsoft/Google)
2. They authenticate with their work account
3. Application receives profile data (name, email, avatar)
4. User account is **automatically created**
5. User is logged in and redirected to dashboard

### Existing Users

When an existing password-based user signs in with SSO:
1. Application matches by email address
2. Account is **linked** to SSO provider
3. Future logins can use either password OR SSO
4. Recommendation: Disable password login after SSO link

### Returning SSO Users

1. Click "Sign in with Microsoft" or "Sign in with Google"
2. Redirected to provider (may auto-login if already authenticated)
3. Returned to app and logged in
4. No password required

---

## Security Considerations

### Token Storage

- SSO tokens are stored in `sso_data` JSON column
- Last sync timestamp tracked in `last_sso_sync`
- User profile synced on each login

### Password Field

- Password field is **nullable** for SSO-only users
- Existing password-based users retain passwords after SSO linking
- Can disable password authentication per tenant

### Multi-Tenant Isolation

- Each tenant can configure their own Microsoft Tenant ID
- Users automatically assigned to tenant based on domain
- Cross-tenant access prevented by middleware

---

## Troubleshooting

### "Redirect URI mismatch"

- **Cause**: Redirect URI in provider config doesn't match application route
- **Fix**: Ensure URLs match exactly (including https vs http)

### "Invalid client secret"

- **Cause**: Secret expired or incorrect
- **Fix**: Regenerate secret in provider dashboard, update .env

### "User not found in directory"

- **Cause**: User's email domain doesn't match tenant domain
- **Fix**:
  - For Microsoft: Use correct Tenant ID
  - For multi-tenant: Use `MICROSOFT_TENANT_ID=common`

### "Permission denied"

- **Cause**: Required API permissions not granted
- **Fix**: Grant admin consent in Azure AD or Google Cloud Console

---

## Local Development

### Use ngrok for local testing

```bash
ngrok http 8000
```

Set redirect URIs to ngrok URL:
```
https://abc123.ngrok.io/auth/microsoft/callback
https://abc123.ngrok.io/auth/google/callback
```

Update .env:
```env
APP_URL=https://abc123.ngrok.io
```

---

## Production Checklist

- [ ] Register apps in production Azure AD / Google Console
- [ ] Use production domain for redirect URIs
- [ ] Store secrets securely (not in version control)
- [ ] Enable admin consent for Microsoft Graph permissions
- [ ] Test SSO flow end-to-end
- [ ] Configure session timeout
- [ ] Set up monitoring for SSO failures
- [ ] Document tenant-specific setup for customers
