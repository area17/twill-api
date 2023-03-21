<?php

namespace A17\Twill\API\Console\Traits;

use Illuminate\Filesystem\Filesystem;

trait HasStubs
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    protected function bootHasStubs(Filesystem $files)
    {
        $this->files = $files;
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
     * Return the stub file path
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/..' . $this->relativeStubPath;
    }

    private function create(): bool
    {
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile();
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            return $path;
        }
        return false;
    }
}
