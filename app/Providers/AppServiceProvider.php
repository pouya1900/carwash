<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        $request = Request::capture();

        $lang = $request->has('lang') ? $request->lang : 'fa';

        app()->setLocale($lang);

        View::composer('*', function ($view) use ($lang) {
            $setting = Setting::first();
            $view->with('setting', $setting);
            $view->with('lang', $lang);
        });
    }
}
