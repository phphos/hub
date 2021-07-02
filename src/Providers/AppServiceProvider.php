<?php

namespace PHPHos\Laravel\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

abstract class AppServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        config('app.debug') && \DB::listen(function ($query) {
            $sql = str_replace('?', '"' . '%s' . '"', $query->sql);
            $sql = vsprintf($sql, $query->bindings);
            $sql = str_replace("\\", "", $sql);
            \Log::info('execution time: ' . $query->time . 'ms; ' . $sql . PHP_EOL);
        });
    }
}
