# User Status System

This document explains how the user status system works in the application and how it restricts access for inactive users.

## Overview

The application now includes a comprehensive user status checking system that:
1. **Prevents inactive users from logging in**
2. **Automatically logs out logged-in inactive users**
3. **Provides clear error messages when access is denied**

## How It Works

### 1. User Status Field
- Users have a `status` field in the database with values: `'active'` or `'inactive'`
- Default status for new users is `'active'`
- Only administrators can change user status

### 2. Login Restriction
- When a user attempts to login, the system checks their status first
- If the user is `inactive`, login is denied with an error message
- If the user is `active`, login proceeds normally

### 3. Automatic Logout During Browsing
- A middleware (`CheckUserStatus`) runs on every request for authenticated users
- If a logged-in user's status becomes `inactive`, they are automatically logged out
- The user is redirected to the login page with an appropriate error message

## Implementation Details

### Files Modified/Created

1. **`app/Http/Controllers/Auth/LoginController.php`**
   - Overrides `attemptLogin()` method to check user status before login
   - Overrides `sendLoginResponse()` method to update last login time

2. **`app/Http/Middleware/CheckUserStatus.php`** (New)
   - Checks user status on every request
   - Automatically logs out inactive users
   - Redirects to login with error message

3. **`app/Http/Kernel.php`**
   - Registers the new middleware
   - Applies it to all web requests

4. **`app/Models/User.php`**
   - Added helper methods: `isActive()` and `isInactive()`
   - These methods check the user's status

5. **`routes/web.php`**
   - Applied the middleware to backend routes

6. **`database/factories/UserFactory.php`**
   - Updated to include all required fields for testing

7. **`tests/Feature/UserStatusTest.php`** (New)
   - Tests for login restriction
   - Tests for automatic logout

8. **`app/Console/Commands/ChangeUserStatus.php`** (New)
   - Artisan command to change user status for testing

### Middleware Configuration

The `CheckUserStatus` middleware is applied in two places:
1. **Global web middleware group** - Runs on every request
2. **Backend routes** - Additional protection for dashboard routes

## Usage

### Testing User Status Changes

Use the artisan command to change user status:

```bash
# Make a user inactive
php artisan user:status user@example.com inactive

# Make a user active
php artisan user:status user@example.com active
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run only user status tests
php artisan test --filter=UserStatusTest
```

## Error Messages

When a user is denied access due to inactive status, they see:
- **During login attempt**: "Your account has been deactivated. Please contact administrator."
- **During browsing**: Same message after being automatically logged out

## Security Considerations

1. **Status checking happens on every request** - This ensures immediate response to status changes
2. **Session is completely cleared** - When logging out inactive users, all session data is removed
3. **Clear error messages** - Users understand why they can't access the system
4. **No bypass possible** - The middleware runs before any route logic

## Database Schema

The users table includes:
```sql
`status` ENUM('active', 'inactive') DEFAULT 'active'
```

## Future Enhancements

Potential improvements could include:
1. **Status change notifications** - Email users when their status changes
2. **Status change logging** - Track who changed user status and when
3. **Bulk status operations** - Change multiple users' status at once
4. **Status change reasons** - Add a reason field for status changes
5. **Temporary deactivation** - Auto-reactivate users after a certain period

## Troubleshooting

### Common Issues

1. **User can't login but status shows active**
   - Check if the user exists in the database
   - Verify the status field value

2. **Middleware not working**
   - Ensure the middleware is registered in `app/Http/Kernel.php`
   - Check if it's applied to the correct route groups

3. **Tests failing**
   - Ensure database is properly configured for testing
   - Check if UserFactory has all required fields

### Debugging

To debug user status issues:
1. Check the user's status in the database
2. Review application logs for authentication errors
3. Use the artisan command to verify status changes
4. Test with the provided test cases
