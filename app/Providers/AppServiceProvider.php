<?php

namespace App\Providers;

use App\Jobs\FetchUserJob;
use App\Services\ConsumeFirstUsersEndpointService;
use App\Services\UserService;
use App\Services\UsersHttpClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton(UsersHttpClient::class, function(){
            return new UsersHttpClient([
                'base_uri' => 'https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/'
            ]);
        });
    }
}
