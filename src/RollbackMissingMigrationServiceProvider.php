<?php

declare(strict_types=1);

namespace Umbrellio\Deploy;

use Illuminate\Support\ServiceProvider;
use Umbrellio\Deploy\Console\RollbackMissingMigrations;

class RollbackMissingMigrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([RollbackMissingMigrations::class]);
        }
    }
}
