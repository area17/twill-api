<?php

namespace Tests;

use A17\Twill\Models\User;
use Faker\Factory as Faker;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use MakesJsonApiRequests;

    const DEFAULT_LOCALE = 'en_US';
    const DEFAULT_PASSWORD = 'secret';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $files;

    /**
     * @var A17\Twill\Models\User
     */
    public $superAdmin;

    /**
     * @var \Faker\Generator
     */
    public $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create(self::DEFAULT_LOCALE);

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/Dummy/database/migrations');

        $this->superAdmin = $this->makeSuperAdmin();

        $this->setUpTwill();

        // $this->artisan('db:seed', ['class' => \Database\Seeders\DatabaseSeeder::class]);

        $this->withoutExceptionHandling();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \LaravelJsonApi\Testing\TestExceptionHandler::class
        );
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('jsonapi.servers', [
            'v1' => \App\JsonApi\V1\Server::class,
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            // Packages
            \A17\Twill\TwillServiceProvider::class,
            \A17\Twill\API\ServiceProvider::class,
            \A17\Twill\API\RouteServiceProvider::class,
            \LaravelJsonApi\Spec\ServiceProvider::class,
            \LaravelJsonApi\Validation\ServiceProvider::class,
            \LaravelJsonApi\Encoder\Neomerx\ServiceProvider::class,
            \LaravelJsonApi\Laravel\ServiceProvider::class,

            // App
            \App\Providers\RouteServiceProvider::class,
        ];
    }

    /**
     * Fake a super admin.
     */
    public function makeSuperAdmin()
    {
        $user = new User();

        $user->setAttribute('name', $this->faker->name);
        $user->setAttribute('email', $this->faker->email);
        $user->setAttribute('password', self::DEFAULT_PASSWORD);
        $user->setAttribute('unencrypted_password', self::DEFAULT_PASSWORD);

        return $this->superAdmin = $user;
    }

    protected function setUpTwill()
    {
        $this->artisan('twill:install')
            ->expectsQuestion('Enter an email', $this->superAdmin->email)
            ->expectsQuestion('Enter a password', $this->superAdmin->password)
            ->expectsQuestion(
                'Confirm the password',
                $this->superAdmin->password
            );
    }
}
