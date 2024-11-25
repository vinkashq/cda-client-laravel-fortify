<?php

namespace Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\Concerns\WithWorkbench; 
use Orchestra\Testbench\TestCase as BaseTestCase;
use Orchestra\Testbench\Attributes\WithMigration;
use Vinkas\Cda\Client\CdaServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase; 

#[WithMigration]
abstract class TestCase extends BaseTestCase
{
    use WithWorkbench;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Workbench\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CdaServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations() 
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
