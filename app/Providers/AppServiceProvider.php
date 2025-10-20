<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\FirebaseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
     
     
     public function register()
     {
         $this->app->singleton(FirebaseService::class, function ($app) {
             return new FirebaseService(); // Add constructor params here if needed
         });
     }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		//setting language
		// Schema::defaultStringLength(191);
		if(isset($_COOKIE['language'])) {
			App::setLocale($_COOKIE['language']);
		} else {
			App::setLocale('English');
		}

//		if (!isset(env('Date_Format')) && !isset($_COOKIE['date_format_js'])){
//
//			setcookie('date_format', 'Y-m-d', time() + (86400 * 365),'/');
//
//			setcookie('date_format_js', 'yyyy-mm-dd', time() + (86400 * 365),'/');
//
//		}

    }
}
