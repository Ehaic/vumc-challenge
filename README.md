Getting this project running

you will need atleast php 8.0 to get this project running.

if you're using WSL(2) on windows (or linux) you can use the [laravel sail utility](https://laravel.com/docs/9.x/sail) to get the project running.

```bash
cp .env.example .env
composer install
php artisan sail:install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail up -d
./vendor/bin/sail npm install
./vendor/bin/sain npm run dev
```

After running the above commands the website should be available at localhost:80

If you're using windows you can just use docker compose.

```
cp .env.example .env
composer install
docker-compose up
docker exec -it vumc-challenge_laravel.test_1 php artisan migrate
docker exec -it vumc-challenge_laravel.test_1 php artisan key:generate
docker exec -it vumc-challenge_laravel.test_1 npm install
docker exec -it vumc-challenge_laravel.test_1 npm run dev
```

After running the above commands the website should be available at localhost:80

the npm run dev command is to run the vite development build server. If you don't plan on making any CSS changes you can
just run `docker exec -it vumc-challenge_laravel.test_1 npm run build` to build the CSS and Javascript once.
