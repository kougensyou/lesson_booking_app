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

1. Create your environment file and fill in values:

```bash
cp backend/.env.example backend/.env
```

Open `backend/.env` and set the parameters (DB, mail, etc.).

2. Build and start the containers:

```bash
docker compose up -d --build
```

3. Stop the containers when done:

```bash
docker compose down
```

## INITIALIZATION (Laravel)
Run these once after the first build:

```bash
docker compose exec backend php artisan migrate
```

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
