# Laravel 13 Upgrade Evaluation

This document outlines the required changes to upgrade the current project from Laravel 11 to Laravel 13 (via Laravel 12), based on an analysis of the codebase against the official Laravel 12 and 13 upgrade guides.

## Table of Contents
1. [Dependency Updates (composer.json)](#dependency-updates)
2. [Files to Change Checklist](#files-to-change-checklist)
3. [Laravel 12 Upgrade Impacts](#laravel-12-upgrade-impacts)
4. [Laravel 13 Upgrade Impacts](#laravel-13-upgrade-impacts)
5. [Low/No Impact Items](#lowno-impact-items)

---

## Dependency Updates

**File to update**: `composer.json`

The following dependencies need to be updated to support Laravel 13. This encompasses the bumps required for both Laravel 12 and Laravel 13.

**`require` block:**
- `"laravel/framework": "^11.0"` $\to$ `"^13.0"`
- `"laravel/tinker": "^2.9"` $\to$ `"^3.0"`

**`require-dev` block:**
- `"phpunit/phpunit": "^11.0.1"` $\to$ `"^12.0"`
- (If using Pest, which is not currently in `require-dev` but mentioned in `allow-plugins`): Ensure it's bumped to `^4.0` if added.

*Note: The Laravel 13 guide suggests adding `laravel/boost: ^2.0` for AI upgrades, but we are excluding this as per project requirements.*

---

## Files to Change Checklist

- [ ] `composer.json` (Bump dependencies)
- [ ] `config/cache.php` (Update `prefix` generation)
- [ ] `config/database.php` (Update `prefix` generation for redis)
- [ ] `config/session.php` (Update `cookie` name generation and add `serialization` option)
- [ ] `bootstrap/app.php` (Verify middleware aliases for CSRF if applicable, though no immediate change is strictly required unless using `VerifyCsrfToken` explicitly)

---

## Laravel 12 Upgrade Impacts

### Carbon 3 Requirement
Laravel 12 removes support for Carbon 2.x and requires Carbon 3.x.
- **Project Impact**: The project explicitly uses Carbon in several controllers (`ProfileControllerOLD.php`, `Auth/VerifyEmailController.php`, `Auth/AuthenticatedSessionController.php`, `Auth/RegisteredUserController.php`, `ProfileController.php`, `ManagerDashboardController.php`).
- **Action Required**: The upgrade to `laravel/framework: ^13.0` will automatically pull in Carbon 3 via Composer. No direct code changes are necessary unless the project relies on deprecated Carbon 2.x methods. (A quick review of usages like `Carbon::now()`, `Carbon::today()`, and `CarbonTimeZone::listIdentifiers()` shows standard functionality that is fully supported in Carbon 3).

### Image Validation Excluding SVGs
The `image` validation rule no longer allows SVG images by default.
- **Project Impact**: The codebase was searched for `image` validation rules in `app/Http/Requests` and `app/Http/Controllers`, and no usages were found.
- **Action Required**: No changes required.

### Models and UUIDv7
The `HasUuids` trait now returns ordered UUIDs (v7). The `HasVersion7Uuids` trait was removed.
- **Project Impact**: A search for `HasUuids`, `HasVersion7Uuids`, and `HasVersion4Uuids` yielded no results in the `app/` or `database/` directories.
- **Action Required**: No changes required.

---

## Laravel 13 Upgrade Impacts

### Cache Prefixes and Session Cookie Names
Laravel's default cache and Redis key prefixes now use hyphenated suffixes (e.g., `laravel-cache-` instead of `laravel_cache_`).
- **Project Impact**: The project's configuration files currently hardcode the older underscore style.
    - `config/cache.php`: `'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache_')`
    - `config/database.php` (redis): `'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_')`
    - `config/session.php`: `'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_') . '_session')`
- **Action Required**: To align with the new Laravel 13 defaults and skeleton, these lines should be updated.
    - `config/cache.php`: `'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel')).'-cache-')`
    - `config/database.php`: `'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel')).'-database-')`
    - `config/session.php`: `'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel')).'-session')`

### Cache `serializable_classes` Configuration
Laravel 13 introduces a `serializable_classes` option set to `false` in `config/cache.php` to prevent PHP deserialization attacks.
- **Project Impact**: The current `config/cache.php` does not have this option.
- **Action Required**: If the project does not intentionally store arbitrary PHP objects in the cache, add `'serializable_classes' => false,` to `config/cache.php` to match the new secure default.

### Session `serialization` Configuration
Laravel 13 skeleton sets the session `serialization` option to `json` in `config/session.php`.
- **Project Impact**: The current `config/session.php` does not have this `serialization` option defined.
- **Action Required**: To improve security, add `'serialization' => 'json',` to `config/session.php`. **Note:** Implementing this on an active production app will invalidate all active user sessions upon deployment. If that is unacceptable, set it to `'php'`.

### Request Forgery Protection
The CSRF middleware was renamed from `VerifyCsrfToken` to `PreventRequestForgery`.
- **Project Impact**: The codebase was searched for `VerifyCsrfToken`, and there are no direct references to it in `bootstrap/app.php`, routes, or tests.
- **Action Required**: No code changes are explicitly required since Laravel maintains `VerifyCsrfToken` as a deprecated alias. However, if any custom middleware exclusion is added in the future, developers should use `PreventRequestForgery`.

---

## Low/No Impact Items

The following items from the upgrade guides were evaluated and found to have **no direct impact** on the current codebase, as the affected features are not utilized in this project:

- **Database `upsert` with MySQL/MariaDB**: No usages found that would violate the new `uniqueBy` empty check.
- **`Container::call` Nullable Class Defaults**: No usages of `Container::call` or `app()->call` found.
- **Domain Route Registration Precedence**: No uses of `domain()` found in route files.
- **Queue Events (`JobAttempted`, `QueueBusy`)**: No custom listeners for these events exist in the app.
- **Pagination Bootstrap View Names**: No direct references to old internal pagination views `pagination::default`.
- **`withScheduling` Registration Timing**: No usages in `bootstrap/app.php` or `app/`.
- **Nested Array Request Merging (`mergeIfMissing`)**: No usages found.
- **Multi-Schema Database Inspecting**: No usages of `Schema::getTables()`, etc.
- **Custom `Str` Factories**: No custom `Str` factories found in tests.
