<?php

namespace A17\Twill\API\Console;

use A17\Twill\API\Console\Traits\HasStubs;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeBlockContentCommand extends Command
{
    use HasStubs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twill-api:block-content {name} {version=v1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a JSON:API block content resource';

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

    protected string $relativeStubPath = '/../../stubs/BlockContent.stub';

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
    public function getBlockName($name)
    {
        return ucwords($name);
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
            'BLOCK_NAME' => $this->getBlockName($this->argument('name')),
        ];
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/'. $this->apiNamespace . '/'.Str::upper($this->version)) .'/Blocks/BlockContent' . $this->getBlockName($this->argument('name')) . '.php';
    }
}
