<?php

namespace App\Providers;

use App\Contracts\PostInterface;
use App\Contracts\ThreadInterface;
use App\Contracts\TopicInterface;
use App\Repositories\PostRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\TopicRepository;
use Illuminate\Database\Eloquent\Model;
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
        $this->registerModelRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // prevent lazy loading
        Model::preventLazyLoading(! app()->isProduction());

        // force https
        if($this->app->environment('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // remove data  wrapper in resources
        JsonResource::withoutWrapping();
    }

    private function registerModelRepositories()
    {
        $this->app->bind(ThreadInterface::class, fn() => new ThreadRepository);
        $this->app->bind(TopicInterface::class, fn() => new TopicRepository);
        $this->app->bind(PostInterface::class, fn() => new PostRepository);
    }
}
