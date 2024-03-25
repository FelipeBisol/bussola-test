<?php

namespace App\Providers;

use App\Repositories\CartItem\CartItemRepository;
use Core\Modules\ShoppingCart\Gateway\CartItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
