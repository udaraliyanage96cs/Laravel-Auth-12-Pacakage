# Laravel Auth 12 Package (`udara/laravel-auth`)

A reusable, modular Authentication, User Management, and Role-Based Administration package for **Laravel 11 & Laravel 12**.

Instead of cloning and maintaining separate boilerplate applications, install this package directly into any Laravel application via Composer and update all your projects with a single `composer update`.

---

## Features Included

- 🔐 **Complete Authentication Suite**: Login, Registration, Forgot Password, Reset Password, Email Verification, Password Confirmation.
- 📱 **Multi-Factor Authentication (MFA / OTP)**: 6-digit email OTP verification with rate limiting and temporary lockouts.
- 🌐 **Google OAuth Integration**: One-click social sign-in via Laravel Socialite.
- 🛡️ **Role & Permission Management**: Built on top of `spatie/laravel-permission` with UI for granular module-level permissions.
- 👥 **User Management**: User listing with filters, admin approval workflows, soft deletes, user restoration, and password resets.
- ⚙️ **Comprehensive Settings Panel**:
  - Toggle self-registration, forgot password, admin approval for new users.
  - Google reCAPTCHA v2 / v3 configuration.
  - Theme / sidebar navbar color customizer.
  - Force default password change on initial login.
- 📜 **Activity Logs**: Automatic audit trail for user creation, logins, updates, role modifications, and deletions.
- 🔔 **In-App Notifications**: Real-time / database notifications with mark-as-read and broadcast capabilities.
- 🛠️ **Module Generator CLI**: `php artisan app:gen-module <Name>` to quickly scaffold new CRUD modules with views, routes, permissions, and sidebar integration.

---

## Installation in a New Laravel Project

### 1. Configure the Repository in your Host Project `composer.json`

Add your GitHub repository to the `repositories` array of your host project:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/YOUR_GITHUB_USERNAME/repoA.git"
    }
]
```

> **For Local Development (Live Symlink):**
> If you are working on the package locally and want immediate updates without pushing to GitHub:
> ```json
> "repositories": [
>     {
>         "type": "path",
>         "url": "../Laravel-Auth-12-Pacakage"
>     }
> ]
> ```

### 2. Require the Package

```bash
composer require udara/laravel-auth
```

### 3. Run the Package Installer

Execute the one-command installer:

```bash
php artisan laravel-auth:install
```

This command will automatically:
1. Publish the configuration file (`config/laravel-auth.php`).
2. Publish admin dashboard static assets to `public/assets`.
3. Publish seeders to `database/seeders`.
4. Run all database migrations.
5. Initialize default roles (`admin`, `user`), default permissions, settings, and seed the default administrator user.

---

### 4. Setup your `User` Model

In your host application's `app/Models/User.php`, simply add the `HasLaravelAuth` trait:

```php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Udara\LaravelAuth\Traits\HasLaravelAuth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasLaravelAuth;

    // Optional: any project-specific fillables or relationships
}
```

---

## Default Administrator Credentials

After running `laravel-auth:install`:

- **Email**: `ldudaraliyanage@gmail.com`
- **Password**: `123456`
- **Dashboard URL**: `http://your-app.test/dashboard`

*(You can customize these defaults in `config/laravel-auth.php` or via environment variables before installing).*

---

## How to Apply Updates across Projects

Whenever you add new features, fix bugs, or improve UI in `repoA`:

1. **Commit and push** your changes in `repoA`:
   ```bash
   git add .
   git commit -m "Add new feature or bugfix"
   git push origin main
   ```
   *(Optional: create a release tag like `git tag v1.0.1 && git push --tags`)*

2. **Update any client project**:
   In any project that uses this package, simply run:
   ```bash
   composer update udara/laravel-auth
   ```
   If there are new migrations or updated assets:
   ```bash
   php artisan migrate
   php artisan vendor:publish --tag=laravel-auth-assets --force
   ```

---

## Configuration & Publishing Options

You can selectively publish components if you wish to override them:

```bash
# Publish configuration
php artisan vendor:publish --tag=laravel-auth-config

# Publish static assets (CSS, JS, Fonts, Images)
php artisan vendor:publish --tag=laravel-auth-assets --force

# Publish Blade views (to override templates)
php artisan vendor:publish --tag=laravel-auth-views

# Publish migrations
php artisan vendor:publish --tag=laravel-auth-migrations

# Publish seeders
php artisan vendor:publish --tag=laravel-auth-seeders

# Publish generator stubs
php artisan vendor:publish --tag=laravel-auth-stubs
```

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
