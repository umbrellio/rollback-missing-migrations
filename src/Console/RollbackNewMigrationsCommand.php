<?php

declare(strict_types=1);

namespace Umbrellio\Deploy\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

class RollbackNewMigrationsCommand extends Command
{
    private const COMMAND = 'git ls-tree --name-only origin/master database/migrations/';

    protected $signature = 'deploy:rollback-new-migrations';
    protected $description = 'Rollback new migrations (default way for k8s staging)';

    public function handle(): void
    {
        if (App::environment('production')) {
            $this->error('It`s restricted to rollback new migrations on production.');
            return;
        }

        $migrationsFromMaster = collect(explode(PHP_EOL, shell_exec(self::COMMAND)))
            ->filter()
            ->map(fn (string $path) => new SplFileInfo(base_path($path)));
        $migrationsFromCurrent = collect(File::files(base_path('database/migrations')));

        /** @var Collection|SplFileInfo[] $migrationsToRollback */
        $migrationsToRollback = $migrationsFromCurrent->keyBy->getFileName()
            ->diffKeys($migrationsFromMaster->keyBy->getFileName())
            ->sort(fn (SplFileInfo $file1, SplFileInfo $file2) => strcmp($file1->getFilename(), $file2->getFilename()))
            ->reverse();

        if ($migrationsToRollback->isEmpty()) {
            $this->info('There are no migrations to rollback.');
            return;
        }

        DB::transaction(function () use ($migrationsToRollback) {
            foreach ($migrationsToRollback as $migration) {
                $this->info('Rolling back: ' . $migration->getFilename());
                $this->downMigrationFile($migration);
            }
        });
    }

    private function downMigrationFile(SplFileInfo $f): void
    {
        require_once $f->getPathname();
        $filename = explode('.php', $f->getRelativePathname())[0];
        $class = Str::studly(implode('_', array_slice(explode('_', $filename), 4)));
        $migration = new $class();
        if (method_exists($migration, 'down')) {
            $migration->down();
            DB::table(config('database.migrations', 'migrations'))->where('migration', $filename)->delete();
        }
    }
}
