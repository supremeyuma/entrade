<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        if ($app->environment('testing')) {
            $defaultConnection = $app['config']->get('database.default');
            $databaseName = $app['config']->get("database.connections.{$defaultConnection}.database");

            if ($defaultConnection !== 'sqlite' || $databaseName !== ':memory:') {
                throw new RuntimeException(sprintf(
                    'Unsafe test database configuration detected. Expected sqlite/:memory:, got %s/%s.',
                    $defaultConnection,
                    (string) $databaseName
                ));
            }
        }

        return $app;
    }
}
