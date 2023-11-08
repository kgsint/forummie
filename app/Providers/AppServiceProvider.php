<?php

namespace App\Providers;

use App\Contracts\ThreadInterface;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ThreadInterface::class, fn() => new ThreadRepository);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // remove data  wrapper in resources
        JsonResource::withoutWrapping();
    }
}
