# Multi-Product Pricing Calculator

This repository contains a Laravel 11 API backend and a Vue 3 + Vite frontend for a multi-product pricing calculator.

## Backend (Laravel)

- Configuration lives in `backend/config/pricing.php`.
- API endpoints:
  - `GET /api/pricing-config` returns the pricing configuration.
  - `POST /api/pricing-calculate` calculates totals based on a selection payload.

## Frontend (Vue 3 + Vite)

- The UI is in Arabic and RTL-friendly.
- Run the frontend from the `frontend` directory.

### Example selection payload

```json
{
  "selection": {
    "vps": { "vcpus": 4, "ram": 8, "ssd": 100, "bw": 1 },
    "backup": { "protected_gb": 200, "retention_days": 30, "managed": true }
  }
}
```
