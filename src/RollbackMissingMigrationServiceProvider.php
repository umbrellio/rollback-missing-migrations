<?php

declare(strict_types=1);

namespace Umbrellio\RollbackMissingMigrations;

use Illuminate\Support\ServiceProvider;
use Umbrellio\RollbackMissingMigrations\Console\RollbackMissingMigrations;
use Umbrellio\RollbackMissingMigrations\Console\RollbackNewMigrations;

class RollbackMissingMigrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([RollbackMissingMigrations::class, RollbackNewMigrations::class]);
        }
    }
}
