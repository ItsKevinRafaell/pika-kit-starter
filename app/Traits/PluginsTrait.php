<?php

namespace App\Traits;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Rules\Password;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Rupadana\ApiService\ApiServicePlugin;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

trait PluginsTrait
{
    protected function setConfiguration(Panel $panel): void
    {
        $this->registerPlugins($panel);
        $this->registerMiddleware($panel);
        $this->registerMethod($panel);
    }

    protected function registerPlugins(Panel $panel): void
    {
        $panel->plugins([
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
                        ->slug($panel->getId()),
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
                    // Comment : You can also use the following method to enable two-factor authentication
                    ->enableTwoFactorAuthentication(
                        force: false,
                    )
        ]);
    }
    protected function registerMiddleware(Panel $panel): void
    {
        $panel->middleware([
            SetTheme::class
        ]);
    }

    protected function registerMethod(Panel $panel): void
    {
        $panel = $panel
                    ->login()
                    ->favicon(asset(config('app.favicon')));
    }


}
