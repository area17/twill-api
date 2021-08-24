#!/usr/bin/env php
<?php

namespace Tests\Dummy;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;

require __DIR__.'/../../vendor/autoload.php';

class UpdateDummy
{
    protected $files;

    public function __construct()
    {
        $this->files =  new Filesystem();
    }

    protected function copyFile($source, $destination)
    {
        if (!$this->files->exists($directory = dirname($destination))) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->files->copy($source, $destination);
    }

    protected function deleteDirectory(string $param)
    {
        if ($this->files->exists($param)) {
            $this->files->deleteDirectory($param);
        }
    }

    public function update()
    {
        $config = Yaml::parseFile(__DIR__ . "/dummy.yml");
        $sources = $config['source'];
        $base = __DIR__ . '/../../' . trim($config['base'], '/') . '/';
        $destBase = __DIR__ . '/';
        $filesets = $config['copy'];

        foreach ($filesets as $fileset) {
            foreach ($fileset['files'] as $file) {
                switch ($fileset['to']) {
                    case 'app':
                        $source = $base . trim($sources['app'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['app'], '/') . '/' . $file;
                        break;
                    case 'config':
                        $source = $base . trim($sources['config'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['config'], '/') . '/' . $file;
                        break;
                    case 'resource':
                        $source = $base . trim($sources['resources'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['resource'], '/') . '/' . $file;
                        break;
                    case 'storage':
                        $source = $base . trim($sources['storage'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['storage'], '/') . '/' . $file;
                        break;
                    case 'public':
                        $source = $base . trim($sources['public'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['public'], '/') . '/' . $file;
                        break;
                    case 'database':
                        $source = $base . trim($sources['database'], '/') . '/' . $file;
                        $destination = $destBase . trim($sources['database'], '/') . '/' . $file;
                        break;
                    case 'base':
                    default:
                        $source = $base . $file;
                        $destination = $destBase . $file;
                }

                $this->copyFile($source, $destination);
            }
        }
    }
}

$copy = new UpdateDummy();
$copy->update();
