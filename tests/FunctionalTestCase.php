<?php

declare(strict_types=1);

namespace Umbrellio\RollbackMissingMigrations\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

abstract class FunctionalTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $params = $this->getConnectionParams();

        $app['config']->set('database.default', 'pgsql');
        $app['config']->set('database.connections.pgsql', [
            'driver' => 'pgsql',
            'host' => $params['host'],
            'port' => (int) $params['port'],
            'database' => $params['database'],
            'username' => $params['user'],
            'password' => $params['password'],
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ]);
        $app['config']->set('database.migrations', 'migrations');
    }

    /**
     * @param Application $app
     */
    protected function resolveApplicationCore($app): void
    {
        parent::resolveApplicationCore($app);

        $app->detectEnvironment(function () {
            return 'testing';
        });
    }

    private function setUpDatabase($app): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../app/database/old_migrations');

        $this->artisan('migrate', [
            '--no-interaction' => true,
        ]);
    }

    private function getConnectionParams(): array
    {
        return [
            'driver' => $GLOBALS['db_type'] ?? 'pdo_pgsql',
            'user' => $GLOBALS['db_username'],
            'password' => $GLOBALS['db_password'],
            'host' => $GLOBALS['db_host'],
            'database' => $GLOBALS['db_database'],
            'port' => $GLOBALS['db_port'],
        ];
    }
}
