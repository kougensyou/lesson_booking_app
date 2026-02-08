# Lesson Booking App (Dockerized)

Full-stack lesson booking app with a Laravel API, Nuxt (SPA) frontend, Nginx reverse proxy, and PostgreSQL configuration.

## USEFUL FOR
- A ready-to-run local environment for a Laravel + Nuxt SPA stack.
- A reference for Docker Compose-based full-stack setups.
- A starting point for staging or internal demos.

## PREREQUISITES
Install Docker Engine and Docker Compose using the official docs:

```text
https://docs.docker.com/compose/install/
```

## RUNNING STEPS
1. Clone the repository:

```bash
cd lesson-booking-app
```

2. Build and start the containers:

```bash
docker compose up -d --build
```

3. Stop the containers when done:

```bash
docker compose down
```

## SERVICES
- Frontend (Nuxt dev server):

```text
http://localhost:3000
```

- Nginx (reverse proxy):

```text
http://localhost
```

- Backend API (via Nginx port mapping):

```text
http://localhost:9000
```

## INITIALIZATION (Laravel)
Run these once after the first build:

```bash
docker compose exec backend php artisan key:generate
docker compose exec backend php artisan migrate
```

## COMMON COMMANDS
- Rebuild everything:

```bash
docker compose up -d --build
```

- Run a backend command:

```bash
docker compose exec backend <command>
```

- Open a shell in a container:

```bash
docker compose exec backend sh
docker compose exec frontend sh
```

## CONFIGURATION
- Backend env: `backend/.env`
- Frontend env (if needed): `frontend/.env`
- Nginx config: `nginx/nginx.conf`

## REFERENCES
- Docker Engine:

```text
https://www.docker.com/
```

- Nginx:

```text
https://nginx.org/
```

- Laravel:

```text
https://laravel.com/
```

- Nuxt:

```text
https://nuxt.com/
```

- PostgreSQL:

```text
https://www.postgresql.org/
```
