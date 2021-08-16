<?php

namespace A17\Twill\API\Tests;

use A17\Twill\API\ServiceProvider;
use A17\Twill\TwillServiceProvider;
use A17\Twill\Models\User;
use Faker\Factory as Faker;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    const DEFAULT_LOCALE = 'en_US';
    const DEFAULT_PASSWORD = 'secret';

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

        $this->artisan('migrate');

        $this->setUpTwill();

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            TwillServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
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
