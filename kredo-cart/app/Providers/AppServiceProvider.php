<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Cart;


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
        View::composer('*', function ($view) {
            $cartItems = collect();

            if(auth()->check()){
                $cart = Cart::where('user_id', auth()->id())
                            ->with('cartItems')
                            ->first();

                $cartItems = $cart?->cartItems ?? collect();
            }

            $view->with('cartItems', $cartItems);
        });

        Gate::define('admin', function ($user) {
            return $user->role === User::ADMIN_ROLE_ID;
        });

        //
        Paginator::useBootstrap();
    }
}
