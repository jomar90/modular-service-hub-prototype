# Modular Service Hub Prototype

A monorepo containing three Laravel applications that together form a modular service hub:

| Application | Port | Role |
|---|---|---|
| `hub` | 8000 | Blade frontend — no database |
| `customer-service` | 8001 | JSON API — Customer data |
| `invoice-service` | 8002 | JSON API — Invoice data |

---

## Quick Start (Docker)

```bash
docker compose up --build
```

Once all containers are healthy, open **http://localhost:8000**.

The API services seed 50 customers and 40 invoices automatically on every startup via `migrate:fresh --seed`. Each restart gives a clean, deterministic state — ideal for local evaluation.

---

## Running Without Docker

Each application is a standard Laravel project. Open three terminals:

```bash
# Terminal 1 — Customer Service
cd customer-service
cp .env.example .env      # already committed with correct defaults
touch database/database.sqlite
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve --port=8001
```

```bash
# Terminal 2 — Invoice Service
cd invoice-service
touch database/database.sqlite
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve --port=8002
```

```bash
# Terminal 3 — Hub
cd hub
php artisan key:generate
php artisan serve --port=8000
```

The hub's `.env` already points `CUSTOMER_SERVICE_URL` and `INVOICE_SERVICE_URL` to `localhost:8001` and `localhost:8002`.

---

## API Reference

### Customer Service (`http://localhost:8001`)

| Method | Endpoint | Query params |
|---|---|---|
| GET | `/api/customers` | `page`, `search`, `ids` |
| GET | `/api/customers/{id}` | — |

### Invoice Service (`http://localhost:8002`)

| Method | Endpoint | Query params |
|---|---|---|
| GET | `/api/invoices` | `page`, `status` (pending/paid/overdue) |
| GET | `/api/invoices/{id}` | — |

Both list endpoints return a paginated response (`15` per page) using Laravel's standard `data` / `links` / `meta` envelope.

---

## Architecture

### Why three separate applications?

The assignment asks for two separate backend APIs with clear separation of concerns. Three independent Laravel apps enforce that boundary physically — the invoice service cannot accidentally query the customer database, and neither service can depend on the hub.

### Hub as a BFF (Backend for Frontend)

The hub is a pure Blade frontend. Its controllers call the two APIs over HTTP using Laravel's `Http` facade and pass the results to views. It owns no data of its own. Service URLs are environment-configurable, so pointing to production APIs requires only a `.env` change.

### Solving the N+1 HTTP problem on the invoice list

Displaying a customer name next to each invoice would normally require one HTTP call per invoice — 15 calls for a single page. Instead, the `InvoiceController` collects all unique `customer_id` values from the page result, then makes **one** HTTP call to `/api/customers?ids=1,2,3…` to fetch only those customers. The result is keyed by ID so the Blade template can look up a customer name in O(1):

```
$customers[$invoice['customer_id']]['name']
```

Total HTTP calls to render the invoice list: **2**, regardless of page size.

### Pagination

All list endpoints use `->paginate(15)`. In the hub, the raw `meta` / `links` JSON from the API is used to reconstruct a `LengthAwarePaginator` instance so Blade can call `$collection->links()` natively. This keeps views clean and unaware that the data came from an external API.

### Docker startup order

The API containers expose a `/up` health check endpoint (built into Laravel). `docker-compose.yml` uses `condition: service_healthy` so the hub only starts once both APIs are ready and seeded. This prevents the hub from serving a page before the APIs are available.

---

## Future Scaling Considerations

This prototype is intentionally simple. In a production system:

- **Auth**: Add API tokens (Laravel Sanctum) to the service-to-service calls, and session-based auth to the hub.
- **Caching**: Cache API responses in Redis to reduce latency and protect the services from traffic spikes.
- **Separate repositories**: Each service moves to its own repo with its own CI/CD pipeline.
- **API Gateway**: Add a gateway (e.g. Kong or a dedicated Laravel proxy) for rate limiting, auth, and request routing.
- **Error resilience**: Replace raw `Http::get()` calls with retry logic and circuit breakers (e.g. Guzzle retry middleware).

None of these are appropriate for the current assignment scope.

---

## Project Structure

```
modular-service-hub/
├── docker-compose.yml
├── README.md
├── hub/                            # Blade frontend
│   ├── app/
│   │   ├── Http/Controllers/       # DashboardController, CustomerController, InvoiceController
│   │   └── Services/               # CustomerApiService, InvoiceApiService
│   └── resources/views/
│       ├── layouts/app.blade.php   # Shared sidebar layout
│       ├── dashboard/
│       ├── customers/
│       └── invoices/
├── customer-service/               # Customer JSON API
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   ├── Http/Resources/
│   │   └── Models/Customer.php
│   └── database/
│       ├── migrations/
│       ├── factories/
│       └── seeders/
└── invoice-service/                # Invoice JSON API
    ├── app/
    │   ├── Http/Controllers/Api/
    │   ├── Http/Resources/
    │   └── Models/Invoice.php
    └── database/
        ├── migrations/
        ├── factories/
        └── seeders/
```
