# Manducart V2 storefront

The standalone Manducart storefront uses Vue 3, TypeScript, Vue Router, Pinia, Axios, Tailwind CSS 4, and Vite 7.

See the [root README](../README.md) for Laravel setup, API routes, environment variables, and current implementation gaps.

## Run locally

Use Node.js 20.19+ within 20.x, or 22.12+, and npm. Start the Laravel API on `127.0.0.1:8000`, then run from this directory:

```bash
npm install
```

Create `.env.local`:

```dotenv
VITE_API_URL=http://127.0.0.1:8000/api
VITE_PUBLIC_API_URL=http://127.0.0.1:8000/api
```

```bash
npm run dev
```

Open [http://localhost:3000](http://localhost:3000). Restart Vite after environment changes. Several components also hardcode the backend URL, so environment variables do not yet control every request. The current lockfile is out of sync with the dependency manifest; use `npm install` for initial setup.

## Scripts

| Command | Purpose |
| --- | --- |
| `npm run dev` | Start Vite on localhost port 3000 |
| `npm run build` | Run `vue-tsc -b` and build with Vite |
| `npm run preview` | Preview a production build locally |

No frontend test or lint script is configured. Search, wishlist, checkout, authentication, and cart limitations are documented in the root README.
