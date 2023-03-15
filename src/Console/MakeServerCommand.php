<?php

namespace A17\Twill\API\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twill:make:server {version=v1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a JSON:API server class';

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
        $this->apiNamespace = config('jsonapi.namespace');
        $this->version = $this->argument('version');
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("{$path} created\n");
            $this->info("Don't forget to add the server to `config/jsonapi.php`:\n");
            $this->info("'servers' => [");
            $this->info("    '$this->version' => \App\\$this->apiNamespace\\".Str::upper($this->version)."\\Server::class,");
            $this->info("],");
        } else {
            $this->info("{$path} already exits");
        }

        return 0;
    }

    /**
     * Return the stub file path
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../stubs/Server.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    public function getStubVariables()
    {
        return [
            'API_NAMESPACE' => config('jsonapi.namespace'),
            'API_VERSION' => Str::upper($this->version),
            'VERSION' => $this->version,
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
        return base_path("app/$this->apiNamespace/".Str::upper($this->version).'/Server.php');
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
