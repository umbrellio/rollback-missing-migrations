<?php

declare(strict_types=1);

namespace Umbrellio\Deploy\Console;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Support\Facades\App;
use Symfony\Component\Process\Process;
use Umbrellio\Deploy\Helpers\DbHelper;

class RollbackMissingMigrations extends BaseCommand
{
    protected $signature = 'rollback_missing_migrations:rollback {path_to_artisan}
        {--path=* : Path(s) where migrations located in current release}
        {--old-path=* : Path(s) where migrations located in previous release}
        {--realpath : Indicate current release migrations files paths are pre-resolved absolute paths}';

    protected $description = 'Rollback missing migrations';

    protected $migrator;
    protected $dbHelper;

    public function __construct(DbHelper $dbHelper)
    {
        $this->migrator = App::make('migrator');
        $this->dbHelper = $dbHelper;

        parent::__construct();
    }

    public function handle()
    {
        $migrationsForRollback = $this->getMigrationsNamesForRollback();

        if (empty($migrationsForRollback)) {
            $this->info('Nothing to rollback');
            return;
        }

        $backup = $this->dbHelper->backupBatchNumbers($migrationsForRollback);
        $nextBatchNumber = $this->migrator->getRepository()
            ->getNextBatchNumber();
        $this->dbHelper->updateBatch($migrationsForRollback, $nextBatchNumber);
        $this->rollback($this->argument('path_to_artisan'));
        $this->dbHelper->restoreBatchNumbers($backup);
        $this->dbHelper->checkIfRollbackIsSuccessful($migrationsForRollback);
    }

    protected function getMigrationsNamesForRollback(): array
    {
        $migrationsFromFiles = array_keys($this->migrator->getMigrationFiles($this->getMigrationPaths()));
        $migrationsFromDb = $this->migrator->getRepository()
            ->getRan();
        return array_diff($migrationsFromDb, $migrationsFromFiles);
    }

    protected function rollback(string $artisanPath): void
    {
        $command = "php {$artisanPath} migrate:rollback {$this->getOldPaths()} {$this->getRealpath()}";
        $process = Process::fromShellCommandline($command);
        $process->run();
        $this->line($process->getOutput());
    }

    protected function getOldPaths(): string
    {
        $targetPaths = [];
        if ($this->input->hasOption('old-path') && $this->option('old-path')) {
            $targetPaths = $this->option('old-path');
        }
        return implode(' ', array_map(function (string $path) {
            return "--path={$path}";
        }, $targetPaths));
    }

    protected function getRealpath(): string
    {
        return $this->usingRealPath() ? '--realpath' : '';
    }
}
