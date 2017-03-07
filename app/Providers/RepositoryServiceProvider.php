<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\RoleRepository::class, \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\PermissionRepository::class, \App\Repositories\Eloquent\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\MenuRepository::class, \App\Repositories\Eloquent\MenuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ArticleRepository::class, \App\Repositories\Eloquent\ArticleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\TagRepository::class, \App\Repositories\Eloquent\TagRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\CategoryRepository::class, \App\Repositories\Eloquent\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ArticleCategoryRepository::class, \App\Repositories\Eloquent\ArticleCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ArticleTagRepository::class, \App\Repositories\Eloquent\ArticleTagRepositoryEloquent::class);
        //:end-bindings:
    }
}
