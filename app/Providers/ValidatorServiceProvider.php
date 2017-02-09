<?php

/*
 * Registrar la nueva clase PassValidator de validación en un Service Provider,
 * luego hay que registrar el Service Provider, en el archivo config/app.php
 * */

namespace App\Providers;

use App\PassValidator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new PassValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
