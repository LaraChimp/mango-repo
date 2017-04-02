<?php

namespace LaraChimp\MangoRepo\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mango:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // Check if annotated option is
        // activated and if so
        // use annotated stub
        if ($this->option('annotated')) {
            return __DIR__.'/stubs/repository_annotated.stub';
        }

        // Return repository stub.
        return __DIR__.'/stubs/repository.stub';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'DummyTargetModel'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->option('model')],
            $stub
        );

        return $this;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Generate the repository class for the given model.'],
            ['annotated', 'a', InputOption::VALUE_NONE, 'Generate a repository using annotation startegy.'],
        ];
    }
}
