# CLAUDE.md

## Aperçu du projet

**H[ERP]ES** est un système ERP personnel pour gérer la comptabilité, créer des devis/offres et suivre les heures de projet.

**Stack technique :**

- Backend : PHP 8.3+ avec Laravel 13
- Frontend : Svelte 5 avec Tailwind CSS 4
- Base de données : SQLite (dev), configurable pour la production (MySQL, PostgreSQL, etc.)
- Outil de build : Vite avec Laravel Vite Plugin
- Authentification : Package AuthUI personnalisé avec réinitialisation de mot de passe par e-mail

**Dépendances principales :**

- `laravel/framework` : ^13.0 - Framework web
- `@sveltejs/vite-plugin-svelte` : ^7.1.2 - Compilateur Svelte
- `tailwindcss` : ^4.0.0 - Framework CSS utilitaire

### Structure monorepo

Le projet utilise un pattern monorepo avec deux packages Laravel principaux dans `packages/danielthalmann/` :

**1. `herpes/` - Système ERP principal**

- Responsable de toute la logique métier : factures, clients, comptes, transactions, bilans
- Définit les modèles, contrôleurs API, composants Svelte et migrations de base de données
- Namespace : `Danielthalmann\Herpes\`
- Enregistré via `HerpesServiceProvider` qui charge :
  - Les migrations depuis `database/migrations/`
  - Les routes depuis `routes/web.php`
  - Le namespace de vues `herpes::`
  - Les composants Blade définis dans `resources/components.php`
  - Les fichiers de traduction depuis `resources/lang/`

**2. `authui/` - Package d'interface d'authentification**

- Fournit l'interface de connexion, réinitialisation de mot de passe et gestion des utilisateurs
- Gère la limitation de débit pour les tentatives de connexion
- Namespace : `Danielthalmann\AuthUi\`
- Enregistré via `AuthUiServiceProvider` qui charge :
  - Les routes pour `/login`, `/auth/email`, `/reset-password`
  - Les vues et composants Blade
  - La commande Artisan : `php artisan user:create` pour créer des utilisateurs
  - Les fichiers de traduction

**3. Application racine (`app/`)**

- Application Laravel principale qui enregistre les deux packages
- Les routes sont minimales (déléguées aux packages)

### Modèles de données et relations

Entités principales (toutes utilisent des clés primaires ULID avec soft deletes si applicable) :

- **Customer** → HasMany AddressCustomer (adresses de facturation/livraison)
- **Invoice** → HasMany InvoiceItem (lignes de facture)
- **Account** (plan comptable)
- **Transaction** (écritures comptables : débit/crédit)
- **BalanceSheet** → HasMany BalanceSheetItem (états financiers)

Les migrations de base de données se trouvent dans :

- Racine : `database/migrations/` (tables users, cache, jobs)
- Package : `packages/danielthalmann/herpes/database/migrations/` (tables du domaine métier)

### Architecture frontend

**Vues et contrôleurs :**

- Les contrôleurs HTTP retournent des vues Blade (ex. `DashboardController`, `CustomerController`)
- Les vues sont des templates qui chargent dynamiquement les composants Svelte

**Composants Svelte :**

Situés dans `packages/danielthalmann/herpes/resources/js/components/` :

- `Table.svelte` - Tableau de données avec recherche, pagination, actions CRUD
- `Form.svelte` - Constructeur de formulaires dynamiques
- `Dialog.svelte` - Boîtes de dialogue modales
- `Input.svelte`, `Select.svelte`, `Button.svelte`, `Checkbox.svelte` - Champs de formulaire
- `Toast.svelte` / `Toasts.svelte` - Système de notifications
- Composant de page : `Customers.svelte` - Interface CRUD complète pour les clients

**Définitions de types :**

- `resources/js/types/App.ts` - Types métier (CustomerType, AddressType)
- `resources/js/types/Laravel.ts` - Types framework (Paginate, réponses de pagination)

**Configuration du build :**

- La config Vite pointe vers `packages/danielthalmann/herpes/resources/` comme entrée principale
- Point d'entrée : `resources/css/app.css` et `resources/js/app.js`
- Initialisation Svelte dans `bootstrap_svelte.ts`, Alpine dans `bootstrap_alpine.js`

### Points d'entrée API

API RESTful pour les clients (protégée par le middleware `auth`) :

- `GET /api/customer` - Lister les clients avec pagination et recherche
- `POST /api/customer` - Créer un client
- `PUT /api/customer/{id}` - Mettre à jour un client
- `DELETE /api/customer/{id}` - Supprimer un client

## Commandes

### Développement

```bash
# Configuration complète (install, env, key, migrate, build)
composer setup

# Lancer le serveur de développement avec rechargement à chaud
# Démarre : serveur Laravel, queue listener, logs, serveur Vite
composer dev

# Build pour la production
npm run build

# Lancer les tests
composer test
```

### Base de données

```bash
# Exécuter les migrations
php artisan migrate

# Créer un nouvel utilisateur (depuis le package authui)
php artisan user:create

# Shell Tinker
php artisan tinker
```

### Qualité du code

```bash
# Laravel Pint (formatage du code)
./vendor/bin/pint

# PHP CS Fixer (formateur alternatif, config dans .php-cs-fixer.php)
./vendor/bin/php-cs-fixer fix
```

## Conventions et directives de style

### Backend (PHP)

- Suivre les conventions Laravel : modèles dans `app/Models/`, contrôleurs dans `app/Http/Controllers/`
- Utiliser le namespace PSR-4 correspondant à la structure de répertoires
- Les fournisseurs de services doivent enregistrer les routes, vues, composants dans la méthode `boot()`
- Base de données : utiliser Eloquent ORM avec les relations ; éviter le SQL brut
- Types : utiliser les types PHP stricts (`?string`, `int`, etc.)

### Frontend (Svelte)

- Les props de composants utilisent les runes Svelte 5 : `$props()`, `$state()`, `$state.raw()` pour les objets complexes
- Gestionnaires de callbacks : `onchange`, `ondelete`, `onsearch`, `oncreate`, `onedit`, `onopen`
- CSS : utiliser les classes utilitaires Tailwind ; éviter les styles inline
- Garder la logique métier dans les contrôleurs, l'état UI dans les composants Svelte
- Définitions de types : utiliser les interfaces TypeScript pour les réponses API

### Migrations de base de données

- Utiliser `Schema::create()` / `Schema::table()` dans `up()`, `Schema::dropIfExists()` dans `down()`
- Les champs nullables doivent utiliser `->nullable()`
- UUID comme clé primaire : `$table->uuid('id')->primary()`
- Utiliser `$table->softDeletes()` pour les modèles avec soft delete
- Toujours inclure `$table->timestamps()` pour created_at/updated_at

## Notes importantes

- **Ne pas modifier les migrations existantes** ni le schéma de base de données sans approbation explicite
- **Garder les composants Svelte synchronisés** avec les changements de l'API backend
- **Support multilingue** : le projet inclut des traductions françaises (`resources/lang/fr/`) ; prendre en compte l'i18n lors de l'ajout de textes UI
- **Authentification** : utilise AuthUI personnalisé avec connexion par e-mail et réinitialisation de mot de passe (pas Laravel Sanctum)
- **Configuration** : les deux packages vérifient `config/herpes.php` et `config/authui.php` pour le flag `enabled` avant l'initialisation

## Tâches en cours

- [x] Sur la base du fichier packages/danielthalmann/herpes/src/Http/Controllers/Api/ApiCustomerController.php refaire un contrôleur pour le modèle AddressCustomer
- [x] Sur la base du fichier packages/danielthalmann/herpes/src/Http/Controllers/CustomerController.php, crée un nouveau point d'entrée pour AddressCustomer. Ajout également la vue dans packages/danielthalmann/herpes/resources/views, ajoute les routes et prépare  le fichier packages/danielthalmann/herpes/resources/js/boostrap_svelte.ts pour inclure l'initialisation de svelte.
- [x] Modifier les routes address-customer de la page de base et celle de l'api afin d'avoir une descendance dans l'url avec customers. Les routes doivent comporter l'id du customer et les requêtes doivent en tenir compte. La table AddressCustomer a une colonne customer_id pour filtrer sur ceux-ci.
- [x] Sur la base des fichiers herpes/Http/Controllers/CustomerController.php, herpes/resources/views/customer.blade.php, herpes/routes/web.php et herpes/resources/js/pages/Customers.svelte crée un nouveau point d'entrée pour le modèle invoice.
- [x] Sur la base des fichiers herpes/Http/Controllers/AddressCustomerController.php, herpes/resources/views/address_customer.blade.php, herpes/routes/web.php et herpes/resources/js/pages/AddressCustomers.svelte crée un nouveau point d'entrée pour le modèle invoiceitem.
- [x] Sur la base des fichiers herpes/Http/Controllers/CustomerController.php, herpes/resources/views/customer.blade.php, herpes/routes/web.php et herpes/resources/js/pages/Customers.svelte crée un nouveau point d'entrée pour le modèle transaction.
- [ ] Créer une nouvelle vue pour saisir les tickets
