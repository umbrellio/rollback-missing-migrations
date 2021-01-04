<?php

namespace Umbrellio\Deploy\Tests\functional\Console;

use Generator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Umbrellio\Deploy\Exceptions\RollbackMissingMigrationException;
use Umbrellio\Deploy\RollbackMissingMigrationServiceProvider;
use Umbrellio\Deploy\Tests\FunctionalTestCase;

class RollbackMissingMigrationsTest extends FunctionalTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RollbackMissingMigrationServiceProvider::class,
        ];
    }

    public function provideMigrations(): Generator
    {
        yield 'same_versions_of_migrations' => [
            'before' => [
                '0000_00_00_000001_create_feature_table1',
                '0000_00_00_000002_create_feature_table2',
                '0000_00_00_000003_create_feature_table3',
                '0000_00_00_000004_add_columns_to_feature_table1',
                '0000_00_00_000006_add_columns_to_feature_table3',
            ],
            'after' => [
                '0000_00_00_000001_create_feature_table1',
                '0000_00_00_000002_create_feature_table2',
                '0000_00_00_000003_create_feature_table3',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideMigrations
     */
    public function rollbackSuccessful(array $before, array $after): void
    {
        $this->assertSame($before, $this->getMigrations());

        Artisan::call('rollback_missing_migrations:rollback', [
            'path_to_artisan' => realpath(__DIR__ . '/../../_data/app/release/artisan'),
            '--realpath' => true,
            '--old-path' => realpath(__DIR__ . '/../../_data/app/database/old_migrations'),
            '--path' => realpath(__DIR__ . '/../../_data/app/database/new_migrations'),
        ]);

        $this->assertSame($after, $this->getMigrations());
    }

    /**
     * @test
     * @dataProvider provideMigrations
     */
    public function nothingToRollback(array $before): void
    {
        $this->assertSame($before, $this->getMigrations());

        Artisan::call('rollback_missing_migrations:rollback', [
            'path_to_artisan' => realpath(__DIR__ . '/../../_data/app/release/artisan'),
            '--realpath' => true,
            '--old-path' => realpath(__DIR__ . '/../../_data/app/database/old_migrations'),
            '--path' => realpath(__DIR__ . '/../../_data/app/database/old_migrations'),
        ]);

        $this->assertSame($before, $this->getMigrations());
    }

    /**
     * @test
     */
    public function rollbackFail(): void
    {
        $this->expectException(RollbackMissingMigrationException::class);

        Artisan::call('rollback_missing_migrations:rollback', [
            'path_to_artisan' => realpath(__DIR__ . '/../../_data/app/release/artisan'),
            '--realpath' => true,
            '--old-path' => realpath(__DIR__ . '/../../_data/app/database/fail_migrations'),
            '--path' => realpath(__DIR__ . '/../../_data/app/database/new_migrations'),
        ]);
    }

    private function getMigrations(): array
    {
        return DB::table('migrations')->get()->pluck('migration')->toArray();
    }
}
