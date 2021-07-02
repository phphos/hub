<?php

namespace PHPHos\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

abstract class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    abstract public function register();
}
