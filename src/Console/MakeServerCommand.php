<?php

namespace A17\Twill\API\Console;

use A17\Twill\API\Console\Traits\HasStubs;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeServerCommand extends Command
{
    use HasStubs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twill-api:server {version=v1}';

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

    protected string $relativeStubPath = '/../../stubs/Server.stub';

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
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path("app/$this->apiNamespace/".Str::upper($this->version).'/Server.php');
    }
}
