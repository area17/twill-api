<?php

namespace A17\Twill\API\Console;

use A17\Twill\API\Console\Traits\HasStubs;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeSchemaCommand extends Command
{
    use HasStubs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twill-api:schema {name} {version=v1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a JSON:API schema';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * API namespace
     * @var string
     */
    protected $apiNamespace;

    /**
     * API version
     * @var string
     */
    protected $version;

    protected string $relativeStubPath = '/../../stubs/ModelSchema.stub';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->bootHasStubs($files);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->apiNamespace = config('jsonapi.namespace');
        $this->version = $this->argument('version');
        $path = $this->getSourceFilePath();
        $created = $this->create();

        if ($created) {
            $singular = $this->getSingularClassName($this->argument('name'));
            $plural = $this->getPluralClassName($this->argument('name'));
            $resource = Str::kebab($plural);
            $schema = $singular . 'Schema';

            $this->info("{$path} created\n");

            $this->info("Add to app/$this->apiNamespace\\".Str::upper($this->version)."\\Server.php:");
            $this->info("\nprotected function allSchemas(): array");
            $this->info("{");
            $this->info("    return [");
            $this->info("        // ...");
            $this->info("        $plural\\$schema::class,");
            $this->info("    ];");
            $this->info("}");

            $this->info("\nAdd to routes/api.php:");

            $this->info("\nJsonApiRoute::server('$this->version')");
            $this->info("    ->prefix('$this->version')");
            $this->info("    ->resources(function (\$server) {");
            $this->info("        \$server->resource('$resource', LaravelJsonApi\Laravel\Http\Controllers\JsonApiController::class)");
            $this->info("            ->relationships(function (\$relationships) {");
            $this->info("                // \$relationships->hasMany('blocks');");
            $this->info("                // \$relationships->hasMany('media');");
            $this->info("                // ...");
            $this->info("            });");
            $this->info("    });");
        } else {
            $this->info("{$path} already exits");
        }

        return 0;
    }

    /**
     * Return the Singular Capitalize Name
     *
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Return the Plural Capitalize Name
     *
     * @param $name
     * @return string
     */
    public function getPluralClassName($name)
    {
        return ucwords(Pluralizer::plural($name));
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariables()
    {
        return [
            'API_NAMESPACE' => $this->apiNamespace,
            'API_VERSION' => Str::upper($this->version),
            'NAMESPACE' => $this->getPluralClassName($this->argument('name')),
            'CLASSNAME' => $this->getSingularClassName($this->argument('name')),
            'MODELNAME' => $this->getSingularClassName($this->argument('name')),
        ];
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/'. $this->apiNamespace . '/'.Str::upper($this->version)) .'/' . $this->getPluralClassName($this->argument('name')) . '/' . $this->getSingularClassName($this->argument('name')) . 'Schema.php';
    }
}
