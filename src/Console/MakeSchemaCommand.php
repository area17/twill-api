<?php

namespace A17\Twill\API\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeSchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twill:make:schema {name}';

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
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);

            $singular = $this->getSingularClassName($this->argument('name'));
            $plural = $this->getPluralClassName($this->argument('name'));
            $resource = Str::lower($plural);

            $this->info("{$path} created\n");

            $this->info("Add to app/TwillApi\V1\Server.php:");
            $this->info("\nprotected function allSchemas(): array");
            $this->info("{");
            $this->info("    return [");
            $this->info("        // ...");
            $this->info("        $plural\\$singular::class,");
            $this->info("    ];");
            $this->info("}");

            $this->info("\nAdd to routes/api.php:");

            $this->info("\nJsonApiRoute::server('v1')");
            $this->info("    ->prefix('v1')");
            $this->info("    ->resources(function (\$server) {");
            $this->info("        \$server->resource('$resource', '\\\\' . JsonApiController::class)");
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
     * Return the stub file path
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../stubs/ModelSchema.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariables()
    {
        return [
            'NAMESPACE' => $this->getPluralClassName($this->argument('name')),
            'CLASSNAME' => $this->getSingularClassName($this->argument('name')),
            'MODELNAME' => $this->getSingularClassName($this->argument('name')),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     */
    public function getSourceFile()
    {
        return $this->getStubContents(
            $this->getStubPath(),
            $this->getStubVariables()
        );
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('{{ '.$search.' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/TwillApi/V1') .'/' . $this->getPluralClassName($this->argument('name')) . '/' . $this->getSingularClassName($this->argument('name')) . 'Schema.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
