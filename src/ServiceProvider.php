<?php

namespace A17\Twill\API;

use A17\Twill\API\Console\MakeSchemaCommand;
use A17\Twill\Models\Block;
use A17\Twill\Models\Setting;
use A17\Twill\API\Models\Mediable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('twill-api')
            ->hasConfigFile()
            ->hasRoute('api')
            ->hasMigration('add_id_column_to_related_table')
            ->hasCommand(MakeSchemaCommand::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function registeringPackage()
    {
        $this->app->singleton('twill-api', function ($app) {
            return $app->make('A17\Twill\API\Controller');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function bootingPackage()
    {
        $this->addBlockMediablesDynamicRelationship();
    }

    public function addBlockMediablesDynamicRelationship()
    {
        Block::resolveRelationUsing('mediables', function ($block) {
            return $block->morphMany(
                Mediable::class,
                'mediable',
            );
        });

        Setting::resolveRelationUsing('mediables', function ($setting) {
            return $setting->morphMany(
                Mediable::class,
                'mediable',
            );
        });
    }
}
