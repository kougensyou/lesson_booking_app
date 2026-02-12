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

## RUNNING STEPS(Local Development Server)

1. Create your environment file and fill in values:

```bash
cp frontend/.env.example frontend/.env
cp backend/.env.example backend/.env
```

Open `frontend/.env`, `backend/.env` and set the parameters (URL, DB, mail, etc.).

2. Build and start the containers:

```bash
docker compose up -d --build
```

※Stop the containers when done:

```bash
docker compose down
```

3. Run these once after the first build:

```bash
docker compose exec backend composer install
docker compose exec backend php artisan migrate
docker compose exec backend php artisan db:seed
docker compose exec backend php artisan storage:link
```

4. type following url on your browser:

```bash
http://localhost:80
```

## TROUBLESHOOTING

### Laravel 500 error: `Permission denied` on `storage/framework/views`

If login or API requests fail with errors like:

```text
file_put_contents(/var/www/storage/framework/views/...): Failed to open stream: Permission denied
```

fix writable permissions for Laravel cache/log directories:

```bash
docker compose exec backend sh -lc 'chown -R 1000:1000 /var/www/storage /var/www/bootstrap/cache'
chmod -R 777 backend/storage backend/bootstrap/cache
```

This can happen when cache/log files are created as `root` inside the backend container.

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
