<?php

namespace Tests;

use A17\Twill\Models\User;
use Faker\Factory as Faker;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
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

        $this->superAdmin = $this->makeSuperAdmin();

        $this->copyFiles();

        $this->artisan('migrate');

        $this->setUpTwill();

        $this->artisan('db:seed');

        $this->withoutExceptionHandling();
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
            'A17\Twill\TwillServiceProvider',
            'A17\Twill\API\ServiceProvider',
            'A17\Twill\API\RouteServiceProvider',

            // App
            'App\Providers\RouteServiceProvider',
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->boot($app);
    }

    /**
     * Boot the TestCase.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function boot($app)
    {
        $this->files = $app->make(Filesystem::class);
    }

    protected function copyFiles()
    {
        $config = Yaml::parseFile(__DIR__ . "/skeleton.yml");
        $sources = $config['source'];
        $base = __DIR__ . '/../' . trim($sources['base'], '/') . '/';
        $filesets = $config['copy'];

        foreach ($filesets as $fileset) {
            foreach ($fileset['files'] as $file) {
                switch ($fileset['to']) {
                    case 'app':
                        $source = $base . $sources['app'] . '/' . $file;
                        $destination = app_path($file);
                        break;
                    case 'config':
                        $source = $base . $sources['config'] . '/' . $file;
                        $destination = config_path($file);
                        break;
                    case 'resource':
                        $source = $base . $sources['resources'] . '/' . $file;
                        $destination = resource_path($file);
                        break;
                    case 'storage':
                        $source = $base . $sources['storage'] . '/' . $file;
                        $destination = storage_path($file);
                        break;
                    case 'public':
                        $source = $base . $sources['public'] . '/' . $file;
                        $destination = public_path($file);
                        break;
                    case 'database':
                        $source = $base . $sources['database'] . '/' . $file;
                        $destination = database_path($file);
                        break;
                    case 'base':
                    default:
                        $source = $base . $file;
                        $destination = base_path($file);
                }

                $this->copyFile($source, $destination);
            }
        }
    }

    protected function copyFile($source, $destination)
    {
        if (!$this->files->exists($directory = dirname($destination))) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->files->copy($source, $destination);
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
}
