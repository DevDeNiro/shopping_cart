# Shopping Cart Setup

## Backend

1. Navigate to the `symfony_backend/` directory.
2. Open the `.env` file and update the `DATABASE_URL` with your database credentials.
3. Run `composer install` to install the required dependencies.
4. Create the database by running `php bin/console doctrine:database:create`.
5. Generate a migration file using `php bin/console make:migration`.
6. Apply the migration to the database with `php bin/console doctrine:migrations:migrate`.
7. Load some products (dummy data) with `php bin/console doctrine:fixtures:load`.
8. Start the Symfony server by running `Symfony server:start` or `php -S localhost:8000 -t public`.

## Frontend

1. Navigate to the `angular_frontend/` directory.
2. Run `npm install` to install the necessary packages.
3. Start the frontend server by running `ng serve` or `npm start`.
4. Navigate to `http://localhost:4200/` to view the application.

