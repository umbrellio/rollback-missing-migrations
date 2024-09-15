<?php

declare(strict_types=1);

namespace Umbrellio\RollbackMissingMigrations\Tests;

use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [];
    }
}
