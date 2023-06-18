<?php

declare(strict_types=1);

namespace Effectra\Generator;

use Effectra\Fs\File;
use Effectra\Generator\Contracts\TemplateInterface;

/**
 * Class GeneratorFunction
 *
 * This class represents a generator for functions.
 */
class GeneratorFunction extends Template
{
    protected Creator $creator;
    protected string $functionName;

    /**
     * GeneratorFunction constructor.
     *
     * @param string $functionName The name of the function to generate.
     */
    public function __construct(string $functionName)
    {
        $this->creator = new Creator();
        $this->functionName = $functionName;
    }

    /**
     * Generate the template.
     *
     * @return TemplateInterface The generated template.
     */
    public function generate(): TemplateInterface
    {
        $clone = clone $this;
        $clone->fileContent .= $this->creator->createFunctionIfNotExists(name: $this->functionName);
        return $clone;
    }

    /**
     * Save the generated file.
     *
     * @param string $path The path to save the file to.
     *
     * @return int|false The number of bytes written or false on failure.
     */
    public function save(string $path): int|false
    {
        return File::put($path, $this->fileContent);
    }
}
