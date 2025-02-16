# Pika Starter Kit

Pika Starter Kit is an innovative solution designed to accelerate the application development process using Filament. With Pika Starter Kit, you can focus on developing features and innovations without getting bogged down in complex configurations.

## Installation

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

## Usage/Examples

To utilize the configured plugins, you need to add `use PluginsTrait` in the panel you wish to use. This trait contains the `setConfiguration` function, which initializes and applies the plugin configurations to the Filament panel.

### Steps to Use Plugins

1. **Add** `use PluginsTrait`**:** In the `panel` that you want to use class, include the following line of code:

    ```php
    use App\Traits\PluginsTrait;
    ```

2. **Call the** `setConfiguration` **function:** Inside the `panel` method, add the following line of code before returning the `$panel` object:

    ```php
    $this->setConfiguration($panel);

    return $panel;
    ```

### Example Code

Here is the complete example code:

```php
<?php

namespace App\Providers\Filament;

use App\Traits\PluginsTrait;
use Filament\Http\Middleware\Authenticate;

class AdminPanelProvider extends PanelProvider
{
    use PluginsTrait;

    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        $this->setConfiguration($panel); // Call the setConfiguration function

        return $panel;
    }
}
```

By adding the above lines of code, the plugin configurations you have defined in the `PluginsTrait` will be applied to your Filament panel.

## Features

The primary purpose of the `PluginsTrait` is to centralize the configuration of plugins, making it easier to manage and modify them as needed. If you wish to make changes to the plugins being used, you can simply open the `PluginsTrait` file and adjust the configurations accordingly.

### Key Functions

1. **setConfiguration(Panel $panel):**

    - This method is responsible for setting up the configuration for the panel. It calls three other methods: `registerPlugins`, `registerMiddleware`, and `registerMethod`.

2. **registerPlugins(Panel $panel):**

    - This method registers all the plugins that will be used in the panel. It includes various plugins such as:
        - `SpotlightPlugin`
        - `ThemesPlugin`
        - `ApiServicePlugin`
        - `FilamentShieldPlugin`
        - `FilamentGeneralSettingsPlugin`
        - `FilamentSpatieLaravelHealthPlugin`
        - `FilamentSocialitePlugin`
        - `BreezyCore`
    - Each plugin can have its own configuration options, such as access control, icons, navigation labels, and more.

3. **registerMiddleware(Panel $panel):**

    - This method registers middleware for the panel. In this case, it includes the `SetTheme` middleware, which is responsible for applying themes to the panel.

4. **registerMethod(Panel $panel):**

    - This method allows you to set additional methods for the panel, such as configuring the login process and setting the favicon.

### Modifying Plugins

If you need to make changes to the plugins being used, you can do so by editing the `PluginsTrait` file. Simply locate the relevant method (e.g., `registerPlugins`) and make your adjustments.

### Documentation for Each Plugin

For detailed usage and configuration options for each plugin, you can refer to the official documentation of the respective plugins. This will provide you with comprehensive information on how to utilize each plugin effectively within your application.

## Plugin

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

## Support

For support, you can give stars to this repo. Thanks for your support

## License

[MIT](https://github.com/ItsKevinRafaell/pika-starter-kit/blob/1.x/LICENSE)
