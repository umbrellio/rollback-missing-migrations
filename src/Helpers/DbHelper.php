<?php

declare(strict_types=1);

namespace Umbrellio\Deploy\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Umbrellio\Deploy\Exceptions\RollbackMissingMigrationException;

class DbHelper
{
    private $migrationTable;

    public function __construct()
    {
        $this->migrationTable = Config::get('database.migrations');
    }

    public function backupBatchNumbers(array $migrationsNames): Collection
    {
        return DB::table($this->migrationTable)
            ->whereIn('migration', $migrationsNames)
            ->get();
    }

    public function updateBatch(array $migrationsNames, int $batchNumber)
    {
        DB::table($this->migrationTable)
            ->whereIn('migration', $migrationsNames)
            ->update(['batch' => $batchNumber]);
    }

    public function restoreBatchNumbers(Collection $backupData)
    {
        $backupData->each(function ($migrationData) {
            DB::table($this->migrationTable)
                ->where('migration', $migrationData->migration)
                ->update(['batch' => $migrationData->batch]);
        });
    }

    public function checkIfRollbackIsSuccessful($migrationsForRollback): void
    {
        $migrations = DB::table($this->migrationTable)
            ->whereIn('migration', $migrationsForRollback)
            ->pluck('migration');
        if ($migrations->isNotEmpty()) {
            throw new RollbackMissingMigrationException($migrations);
        }
    }
}
