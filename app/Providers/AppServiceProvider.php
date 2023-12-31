<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Services\OgImageGenerator;
use App\Settings\GeneralSettings;
use App\SocialProviders\SsoProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

class AppServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('partials.meta', static function ($view) {
            $view->with(
                'defaultImage',
                OgImageGenerator::make(config('app.name'))
                    ->withSubject('Roadmap')
                    ->withPolygonDecoration()
                    ->withFilename('og.jpg')
                    ->generate()
                    ->getPublicUrl()
            );
        });

        Filament::serving(function () {
            Filament::registerRenderHook(
                'head.end',
                static fn () => (new Vite)(['resources/css/admin.css'])
            );
        });

        Filament::registerNavigationItems([
            NavigationItem::make()
                ->group('External')
                ->sort(101)
                ->label('Public view')
                ->icon('heroicon-o-rewind')
                ->isActiveWhen(fn (): bool => false)
                ->url('/'),
        ]);

        Filament::registerRenderHook(
            'head.end',
            fn (): \Illuminate\Contracts\View\View => view('components.header-scripts'),
        );

        Filament::registerRenderHook(
            'body.end',
            fn (): \Illuminate\Contracts\View\View => view('components.footer-scripts'),
        );

        Filament::registerRenderHook(
            'body.end',
            fn (): string => Blade::render('@livewire(\'livewire-ui-modal\')'),
        );

        if (file_exists($favIcon = storage_path('app/public/favicon.png'))) {
            config(['filament.favicon' => asset('storage/favicon.png') . '?v=' . md5_file($favIcon)]);
        }

        $this->bootSsoSocialite();
        $this->bootCollectionMacros();

        // if (app(GeneralSettings::class)->users_must_verify_email) {
        //  $this->addVerificationMiddleware($kernel);
        // }
    }

    private function bootSsoSocialite(): void
    {
        $socialite = $this->app->make(SocialiteFactory::class);

        $socialite->extend('sso', static function ($app) use ($socialite) {
            $config = $app['config']['services.sso'];

            return $socialite->buildProvider(SsoProvider::class, $config);
        });
    }

    private function bootCollectionMacros(): void
    {
        Collection::macro('prioritize', function ($callback): Collection {
            $nonPrioritized = $this->reject($callback);

            return $this
                ->filter($callback)
                ->merge($nonPrioritized);
        });
    }

    protected function addVerificationMiddleware(Kernel $kernel)
    {
        $kernel->appendMiddlewareToGroup('authed', 'verified');
    }
}
