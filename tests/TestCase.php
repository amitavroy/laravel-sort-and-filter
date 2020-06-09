<?php

namespace Amitav\SortAndFilter\Tests;

use Amitav\SortAndFilter\SortAndFilterServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/database/factories');

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            SortAndFilterServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_skeleton_tables.php.stub';
        (new CreatePackageTables())->up();
        */
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('country');
            $table->integer('wins');
            $table->timestamps();
        });
    }
}
