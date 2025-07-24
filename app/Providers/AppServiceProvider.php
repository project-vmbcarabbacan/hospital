<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Interfaces\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Interfaces\Repositories\AuthRepositoryInterface;
use App\Infrastructure\Repositories\AuthRepository;
use App\Domain\Interfaces\Repositories\DepartmentSpecializationRepositoryInterface;
use App\Infrastructure\Repositories\DepartmentSpecializationRepository;
use App\Domain\Interfaces\Repositories\DistProductServiceRepositoryInterface;
use App\Infrastructure\Repositories\DistProductServiceRepository;

use App\Domain\Interfaces\Services\AuthServiceInterface;
use App\Application\Services\AuthService;

use App\Domain\Interfaces\Services\RoleServiceInterface;
use App\Application\Services\RoleService;
use App\Infrastructure\Readers\RoleFileReader;
use App\Application\Mappers\RoleDataMapper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(DepartmentSpecializationRepositoryInterface::class, DepartmentSpecializationRepository::class);
        $this->app->bind(DistProductServiceRepositoryInterface::class, DistProductServiceRepository::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        // $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->singleton(RoleServiceInterface::class, function ($app) {
            return new RoleService(
                new RoleFileReader(),
                new RoleDataMapper()
            );
        });

        foreach (glob(app_path('Support/Helpers') . '/*.php') as $file) {
            require_once $file;
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
