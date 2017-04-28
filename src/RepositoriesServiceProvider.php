<?php

namespace Dblencowe\Repository;

use Dblencowe\Repository\Commands\RepositoryMakeCommand;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register commands
        $this->commands([
            RepositoryMakeCommand::class,
        ]);
    }
}
