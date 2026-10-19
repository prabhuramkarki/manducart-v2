# Manducart V2

Manducart V2 is an e-commerce project with a Vue storefront and Laravel API. It includes product browsing, product detail pages, account screens, cart operations, a contact form, and an admin interface for listing and adding products. Several flows are still under development; see [Current limitations](#current-limitations).

## Stack and layout

| Directory | Purpose |
| --- | --- |
| [manducart-v2-frontend](manducart-v2-frontend/) | Vue 3, TypeScript, Vue Router, Pinia, Axios, Tailwind CSS 4, and Vite 7 storefront |
| [manducart-v2-backend](manducart-v2-backend/) | Laravel 12 API, Sanctum authentication, database migrations, and a separate Inertia/Vue starter interface |

The standalone storefront runs on port **3000**. Laravel serves the API under `/api` on port **8000**. The backend's own Vite assets belong to its Inertia interface, not the standalone storefront.

## Requirements

- PHP **8.3+** and Composer. The application declares PHP `^8.2`, but the locked Pest 4 development dependencies require PHP `^8.3` for a normal `composer install`.
- PHP extensions required by Laravel and Composer, including PDO SQLite for the default database.
- Node.js **20.19+ within 20.x, or 22.12+**, and npm, matching Vite's engine requirement.
- SQLite by default; another Laravel-supported database can be configured in the backend `.env`.

## Local setup

Run these commands from the repository root unless a different directory is shown.

### 1. Laravel API

```bash
cd manducart-v2-backend
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8000
```

The example environment uses SQLite and database-backed sessions, cache, and queues. For another database, update the `DB_*` values before migrating. Keep `.env` private.

Migrations create the schema, not a product catalog or an admin account. The optional `php artisan db:seed` creates only a test user; there is no supplied product/admin seeder. Product creation currently assumes a creator with user ID `1`.

### 2. Vue storefront

In another terminal:

```bash
cd manducart-v2-frontend
npm install
```

Create `.env.local` in that directory:

```dotenv
VITE_API_URL=http://127.0.0.1:8000/api
VITE_PUBLIC_API_URL=http://127.0.0.1:8000/api
```

Both variables are needed because the project has two API clients. Some pages and image URLs also hardcode `http://127.0.0.1:8000`, so changing these variables alone does not relocate every request.

```bash
npm run dev
```

Open [http://localhost:3000](http://localhost:3000). Restart Vite after changing environment variables. Use `npm install` for the initial setup: the checked-in npm lockfiles do not fully match the manifests, including the storefront's Pinia dependency.

### 3. Optional Laravel/Inertia interface

To work on the separate interface in `manducart-v2-backend/resources/js`, install its JavaScript dependencies and run its Vite server:

```bash
cd manducart-v2-backend
npm install
npm run dev
```

Keep Laravel running in another terminal. Alternatively, after installing these dependencies, `composer run dev` starts Laravel, the queue listener, logs, and backend Vite together.

## API reference

Routes are defined in [routes/api.php](manducart-v2-backend/routes/api.php). Examples below assume the Laravel server is running locally.

```bash
curl -H 'Accept: application/json' http://127.0.0.1:8000/api/products
curl -H 'Accept: application/json' 'http://127.0.0.1:8000/api/cart?user_id=1'
```

An empty catalog returns an empty `data` array. A product list response includes `message`, `count`, and `data`; individual products include their related category.

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/api/products` | List products and categories |
| GET | `/api/products/{id}` | Get one product |
| POST | `/api/products` | Product creation handler; see route caveat below |
| POST | `/api/signup` | Register with `fullname`, `email`, `password`, `password_confirmation` |
| POST | `/api/login` | Log in with `email` and `password`; returns user and token |
| GET | `/api/user` | Current user; requires a Sanctum bearer token |
| GET | `/api/admin/dashboard` | Requires Sanctum authentication and the admin role |
| POST | `/api/contact` | Submit the contact form |
| GET / POST | `/api/cart` | List by `user_id` / add `user_id`, `product_id`, `quantity` |
| PUT / DELETE | `/api/cart/{id}` | Set `quantity` / remove a cart item |
| POST | `/api/cart/clear` | Clear items for a supplied `user_id` |

The POST product route currently contains a trailing space in its source declaration (`'/products '`). Correct that route before relying on the admin add-product form. A logout route is declared, but its controller method is missing.

## Development commands

Run each command in its own application directory.

| Directory | Command | Purpose |
| --- | --- | --- |
| `manducart-v2-frontend` | `npm run dev` | Start the storefront |
| `manducart-v2-frontend` | `npm run build` | Type-check and build the storefront |
| `manducart-v2-frontend` | `npm run preview` | Preview a storefront build |
| `manducart-v2-backend` | `composer test` | Clear configuration cache and run the PHP test suite |
| `manducart-v2-backend` | `npm run build` | Build the Inertia interface assets |
| `manducart-v2-backend` | `npm run format:check` | Check formatting under `resources/` |
| `manducart-v2-backend` | `npm run lint` | Run ESLint with automatic fixes |

The PHP tests include Laravel starter authentication/settings coverage. These commands are references, not a claim that builds or tests currently pass. No storefront test script is configured.

## Current limitations

- Search and wishlist pages are placeholders; no wishlist API is implemented. Checkout, orders, and payments are not implemented.
- The cart uses demo user ID `1`, and `useCart.js` references an undefined `api` client. The cart flow needs integration work.
- Cart routes accept caller-supplied user/item IDs without authentication or ownership checks. Product creation is also public and assumes creator ID `1`.
- Registration accepts a client-supplied role. The auth flow and API authorization need review before use with real users; frontend route guards do not secure backend endpoints.
- API addresses are partly hardcoded, and no production deployment configuration is supplied.

Use local test data while completing these flows. This repository is a development project, not a finished production storefront.
