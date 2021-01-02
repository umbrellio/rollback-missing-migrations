<?php

declare(strict_types=1);

namespace Umbrellio\Deploy\Exceptions;

use Exception;
use Illuminate\Support\Collection;
use Throwable;

class RollbackMissingMigrationException extends Exception
{
    public function __construct(Collection $migrations, $code = 0, Throwable $previous = null)
    {
        $title = 'Rollback migrations failed. Migrations which are not rolled back:';
        $message = $migrations->prepend($title)
            ->join(PHP_EOL);

        parent::__construct($message, $code, $previous);
    }
}
