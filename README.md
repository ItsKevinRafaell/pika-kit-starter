# Pika Starter Kit

Pika Starter Kit is an innovative solution designed to accelerate the application development process using Filament. With Pika Starter Kit, you can focus on developing features and innovations without getting bogged down in complex configurations.

## Installation Steps

The following steps detail the installation process. Each step includes the command to execute and a detailed explanation.

1.  **Copy the Environment File:**

    ```bash
    cp .env.example .env
    ```

    This command copies the `.env.example` file to `.env`. The `.env` file contains environment-specific configurations such as database credentials, API keys, and other sensitive information. **Do not commit this file to version control.** Open `.env` and replace the placeholder values with your actual database credentials and other necessary settings. For example:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    APP_URL=http://your-app-url.com
    APP_KEY=base64:some_random_string #This will be generated later
    ```

2.  **Install Dependencies:**

    ```bash
    composer install
    ```

3.  **Run Database Migrations:**

    ```bash
    php artisan migrate:fresh
    ```

4.  **Set up Laravel Shield:**

    ```bash
    php artisan shield:setup
    ```

5.  **Install Shield Admin:**

    ```bash
    php artisan shield:install admin
    ```

6.  **Create a Super Admin Account:**

    ```bash
    php artisan make:filament-user
    ```

    This command creates a new Filament user. You will be prompted to enter the necessary details for the superadmin account. This user will have full access to the application..

7.  **Generate Shield Permissions:**

    ```bash
    php artisan shield:generate --all
    ```

8.  **Assign Super Admin Role:**

    ```bash
    php artisan shield:super-admin
    ```

    This command assigns the newly created user the Super Admin role, granting them full access to the application's features.

9.  **Create Storage Symbolic Link:**

    ```bash
    php artisan storage:link
    ```

10. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

# Plugin

| Plugin Name        | URL                                                                                                                                |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| Filament Breezy    | [https://filamentphp.com/plugins/jeffgreco-breezy](https://filamentphp.com/plugins/jeffgreco-breezy)                               |
| Shield             | [https://filamentphp.com/plugins/bezhansalleh-shield](https://filamentphp.com/plugins/bezhansalleh-shield)                         |
| Spatie Health      | [https://filamentphp.com/plugins/shuvroroy-spatie-laravel-health](https://filamentphp.com/plugins/shuvroroy-spatie-laravel-health) |
| Themes             | [https://filamentphp.com/plugins/hasnayeen-themes](https://filamentphp.com/plugins/hasnayeen-themes)                               |
| API Service        | [https://filamentphp.com/plugins/rupadana-api-service](https://filamentphp.com/plugins/rupadana-api-service)                       |
| Filament Socialite | [https://filamentphp.com/plugins/dododedodonl-socialite](https://filamentphp.com/plugins/dododedodonl-socialite)                   |
| Spotlight          | [https://filamentphp.com/plugins/pxlrbt-spotlight](https://filamentphp.com/plugins/pxlrbt-spotlight)                               |
| General Setting    | [https://filamentphp.com/plugins/joaopaulolndev-general-settings](https://filamentphp.com/plugins/joaopaulolndev-general-settings) |
