<?php

namespace Dblencowe\Repository\Commands;

use App\Helpers\Str;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class RepositoryCreator
{
    /** @var \Illuminate\Filesystem\Filesystem $files */
    protected $files;

    /** @var string $stubPath */
    private $stubPath;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->stubPath = __DIR__ . '/stubs';
    }

    public function create(string $name, string $path)
    {
        $this->ensureTargetDoesNotExist($name);

        $path = $this->getPath($name, $path);

        $this->files->put($path, $this->getStub($name));
    }

    protected function getPath($name, $path)
    {
        return $path . '/' . $this->getDatePrefix() . '_' . $name . '.php';
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    protected function getClassName($name)
    {
        return Str::studly($name);
    }

    private function ensureTargetDoesNotExist($name)
    {
        if (class_exists($className = $this->getClassName($name))) {
            throw new InvalidArgumentException("A $className migration already exists.");
        }
    }

    protected function getStub(string $name)
    {
        $stub = $this->files->get($this->stubPath . '/repository.stub');

        return str_replace('DummyClass', $this->getClassName($name), $stub);
    }
}
