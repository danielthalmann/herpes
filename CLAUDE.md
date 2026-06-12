# CLAUDE.md

## Project Overview

**H[ERP]ES** is a personal ERP system for managing accounting, creating quotes/offers, and tracking project hours.

**Tech Stack:**
- Backend: PHP 8.3+ with Laravel 13
- Frontend: Svelte 5 with Tailwind CSS 4
- Database: SQLite (dev), configurable for production (MySQL, PostgreSQL, etc.)
- Build Tool: Vite with Laravel Vite Plugin
- Authentication: Custom AuthUI package with password reset via email

**Key Dependencies:**
- `laravel/framework`: ^13.0 - Web framework
- `@sveltejs/vite-plugin-svelte`: ^7.1.2 - Svelte compiler
- `tailwindcss`: ^4.0.0 - Utility CSS framework

### Monorepo Structure

The project uses a monorepo pattern with two main Laravel packages in `packages/danielthalmann/`:

**1. `herpes/` - Core ERP System**
- Responsible for all business logic: invoices, customers, accounts, transactions, balance sheets
- Defines models, API controllers, Svelte components, and database migrations
- Namespace: `Danielthalmann\Herpes\`
- Registered via `HerpesServiceProvider` which loads:
  - Database migrations from `database/migrations/`
  - Routes from `routes/web.php`
  - Views namespace `herpes::`
  - Blade components defined in `resources/components.php`
  - Translation files from `resources/lang/`

**2. `authui/` - Authentication UI Package**
- Provides login, password reset, and user management UI
- Handles rate limiting for login attempts
- Namespace: `Danielthalmann\AuthUi\`
- Registered via `AuthUiServiceProvider` which loads:
  - Routes for `/login`, `/auth/email`, `/reset-password`
  - Blade views and components
  - Artisan command: `php artisan user:create` for creating users
  - Translation files

**3. Root Application (`app/`)**
- Main Laravel application that registers both packages
- Contains Filament admin panel resources for data management
- Filament Resources: Customers, Invoices, Accounts, Transactions
- Routes are minimal (delegated to packages)

### Data Models & Relationships

Core entities (all use ULID primary keys with soft deletes where applicable):

- **Customer** → HasMany AddressCustomer (billing/shipping addresses)
- **Invoice** → HasMany InvoiceItem (line items for invoices)
- **Account** (chart of accounts for accounting)
- **Transaction** (journal entries: debit/credit bookkeeping)
- **BalanceSheet** → HasMany BalanceSheetItem (financial statements)

Database migrations are located in:
- Root: `database/migrations/` (users, cache, jobs tables)
- Package: `packages/danielthalmann/herpes/database/migrations/` (business domain tables)

### Frontend Architecture

**Views & Controllers:**
- HTTP Controllers return Blade views (e.g., `DashboardController`, `CustomerController`)
- Views are template files that load Svelte components dynamically

**Svelte Components:**
Located in `packages/danielthalmann/herpes/resources/js/components/`:
- `Table.svelte` - Data table with search, pagination, CRUD actions
- `Form.svelte` - Dynamic form builder
- `Dialog.svelte` - Modal dialogs
- `Input.svelte`, `Select.svelte`, `Button.svelte`, `Checkbox.svelte` - Form fields
- `Toast.svelte` / `Toasts.svelte` - Notification system
- Page component: `Customers.svelte` - Full CRUD interface for customers

**Type Definitions:**
- `resources/js/types/App.ts` - Business types (CustomerType, AddressType)
- `resources/js/types/Laravel.ts` - Framework types (Paginate, pagination responses)

**Build Configuration:**
- Vite config points to `packages/danielthalmann/herpes/resources/` as main entry
- Entry point: `resources/css/app.css` and `resources/js/app.js`
- Svelte initialization in `bootstrap_svelte.ts`, Alpine in `bootstrap_alpine.js`

### API Endpoints

RESTful API for customers (protected by `auth` middleware):
- `GET /api/customer` - List customers with pagination and search
- `POST /api/customer` - Create customer
- `PUT /api/customer/{id}` - Update customer
- `DELETE /api/customer/{id}` - Delete customer

## Commands

### Development

```bash
# Full setup (install, env, key, migrate, build)
composer setup

# Run dev server with hot reload
# Starts: Laravel server, queue listener, logs, Vite dev server
composer dev

# Build for production
npm run build

# Run tests
composer test
```

### Database

```bash
# Run migrations
php artisan migrate

# Create a new user (from authui package)
php artisan user:create

# Tinker shell
php artisan tinker
```

### Code Quality

```bash
# Laravel Pint (code formatting)
./vendor/bin/pint

# PHP CS Fixer (alternative formatter, config in .php-cs-fixer.php)
./vendor/bin/php-cs-fixer fix
```

## Convention & Style Guidelines

### Backend (PHP)

- Follow Laravel conventions: models in `app/Models/`, controllers in `app/Http/Controllers/`
- Use PSR-4 namespacing matching directory structure
- Service providers should register routes, views, components in `boot()` method
- Database: Use Eloquent ORM with relationships; avoid raw SQL
- Type hints: Use strict PHP types (`?string`, `int`, etc.)

### Frontend (Svelte)

- Component props use Svelte 5 runes: `$props()`, `$state()`, `$state.raw()` for complex objects
- Callback handlers: `onchange`, `ondelete`, `onsearch`, `oncreate`, `onedit`, `onopen`
- CSS: Use Tailwind utility classes; avoid inline styles
- Keep business logic in controllers, UI state in Svelte components
- Type definitions: Use TypeScript interfaces for API responses

### Database Migrations

- Use `Schema::create()` / `Schema::table()` in `up()`, `Schema::dropIfExists()` in `down()`
- Nullable fields should use `->nullable()`
- UUIDs as primary key: `$table->uuid('id')->primary()`
- Use `$table->softDeletes()` for soft-delete models
- Always include `$table->timestamps()` for created_at/updated_at

## Important Notes

- **Do not modify existing migrations** or database schema without explicit approval
- **Keep Svelte components in sync** with backend API changes
- **Language support**: The project includes French translations (`resources/lang/fr/`); consider i18n when adding UI text
- **Filament resources** in `app/Filament/` are for admin panel management; separate from Svelte customer-facing UI
- **Authentication**: Uses custom AuthUI with email-based login and password reset (not Laravel Sanctum)
- **Configuration**: Both packages check `config/herpes.php` and `config/authui.php` for `enabled` flag before initializing


## working tasks
- [x] Sur la base du fichier packages/danielthalmann/herpes/src/Http/Controllers/Api/ApiCustomerController.php refaire un contrôleur pour le modèle AddressCustomer
- [x] Sur la base du fichier packages/danielthalmann/herpes/src/Http/Controllers/CustomerController.php, crée un nouveau point d'entrée pour AddressCustomer. Ajout également la vue dans packages/danielthalmann/herpes/resources/views, ajoute les routes et prépare  le fichier packages/danielthalmann/herpes/resources/js/boostrap_svelte.ts pour inclure l'initialisation de svelte.
- [x] Modifier les routes address-customer de la page de base et celle de l'api afin d'avoir une descendance dans l'url avec customers. Les routes doivent comporter l'id du customer et les requêtes doivent en tenir compte. La table AddressCustomer a une colonne customer_id pour filtrer sur ceux-ci.
