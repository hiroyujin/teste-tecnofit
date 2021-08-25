<?php

namespace App\Providers;

use App\Models\PersonalRecord;
use App\Observers\PersonalRecordObserver;
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
        PersonalRecord::observe(PersonalRecordObserver::class);
    }
}
