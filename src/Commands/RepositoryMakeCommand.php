<?php

namespace Dblencowe\Repository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

class RepositoryMakeCommand extends Command
{
    /** @var string $signature */
    protected $signature = 'make:repository {model : The name of the model}';

    /** @var string $description */
    protected $description = 'Create a new repository';

    /** @var  Composer $composer */
    private $composer;

    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Create a repository
     */
    public function handle()
    {
        $modelName = ucfirst(trim($this->argument('model')));

        $this->writeRepositoryFile($modelName);

        $this->composer->dumpAutoloads();
    }

    private function writeRepositoryFile($modelName)
    {

    }
}
