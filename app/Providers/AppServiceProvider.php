<?php

namespace App\Providers;

use App\Contracts\ThreadInterface;
use App\Contracts\TopicInterface;
use App\Repositories\ThreadRepository;
use App\Repositories\TopicRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ThreadInterface::class, fn() => new ThreadRepository);
        $this->app->bind(TopicInterface::class, fn() => new TopicRepository);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        // remove data  wrapper in resources
        JsonResource::withoutWrapping();
    }
}
