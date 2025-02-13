<?php

namespace App\Providers\Filament;

use App\Models\User;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Rupadana\ApiService\ApiServicePlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
                SetTheme::class
            ])
            ->plugins([
                SpotlightPlugin::make(),
                ThemesPlugin::make(),
                ApiServicePlugin::make(),
                FilamentShieldPlugin::make(),
                FilamentGeneralSettingsPlugin::make()
                    ->setIcon('heroicon-o-cog')
                    ->setNavigationGroup('Core')
                    ->setTitle('General Settings')
                    ->setNavigationLabel('General Settings'),
                FilamentSpatieLaravelHealthPlugin::make(),
                FilamentSocialitePlugin::make()
            ->providers([
                Provider::make('google')
                    ->label('Google')
                    ->icon('fab-google')
                    ->color(Color::hex('#ea4335'))
                    ->outlined(false)
                    ->stateless(false)
                    ->scopes(['openid', 'email', 'profile']),
                Provider::make('gitlab')
                    ->label('GitLab')
                    ->icon('fab-gitlab')
                    ->color(Color::hex('#2f2a6b'))
                    ->outlined(false)
                    ->stateless(false)
                    ->scopes(['read_user', 'email'])
                    ->with(['email']),
                Provider::make('github')
                    ->label('GitHub')
                    ->icon('fab-github')
                    ->color(Color::hex('#333'))
                    ->outlined(false)
                    ->stateless(false)
                    ->scopes(['read:user', 'user:email'])
                    ->with(['email', 'name']),
            ])
            ->registration(false)
            ->registration(fn (string $provider, SocialiteUserContract $oauthUser, ?Authenticatable $user) => (bool) $user)
            ->slug('admin'),
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: true, // Adds a main navigation item for the My Profile page (default = false)
                        navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                        hasAvatars: true, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
                        requiresCurrentPassword: true, // when false, the user can update their password without entering their current password. (default = true)
                    )
                    ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
                    ->enableTwoFactorAuthentication(
                        force: true, // force the user to enable 2FA before they can use the application (default = false)
                    )
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
