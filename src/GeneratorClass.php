<?php

declare(strict_types=1);

namespace Effectra\Generator;

use Effectra\Generator\Contracts\TemplateInterface;

/**
 * Class GeneratorClass
 *
 * This class represents a generator for creating PHP class files.
 */
class GeneratorClass extends Template
{
    /**
     * @var Creator The creator instance used for generating code snippets.
     */
    protected Creator $creator;

    /**
     * @var string The name of the class.
     */
    protected string $className = '';

    /**
     * GeneratorClass constructor.
     *
     * @param Creator $creator    The creator instance used for generating code snippets.
     * @param string  $className  (optional) The name of the class.
     */
    public function __construct(
        Creator $creator,
        string $className = ''
    ) {
        $this->creator = $creator;
        $this->className = $className;
    }

    /**
     * Set the name of the class.
     *
     * @param string $name The name of the class.
     * @return GeneratorClass A new instance of GeneratorClass with the updated class name.
     */
    public function setName(string $name): GeneratorClass
    {
        $clone = clone $this;
        $clone->className = $name;
        return $clone;
    }

    /**
     * Generate the PHP code for the class.
     *
     * @return TemplateInterface The generated PHP code.
     */
    public function generate(): TemplateInterface
    {
        $clone = clone $this;

        //start php file
        $clone->fileContent = $this->creator->start();

        //add declare
        $clone->fileContent .= $this->creator->declare();

        //add namespace
        if ($this->namespace) {
            $clone->fileContent .= $this->creator->createNamespace($this->namespace);
        }

        //add packages
        if (count($this->packages) !== 0) {
            $clone->fileContent .= $this->creator->createPackages($this->packages);
        }

        // add className 
        $clone->fileContent .= $this->creator->createClassStart($this->className);

        // add extends
        if ($this->extends) {
            $clone->fileContent .= $this->creator->createExtends($this->extends);
        }

        // add implements
        if ($this->implements) {
            $clone->fileContent .= $this->creator->createImplements($this->implements);
        }

        // add opening to class
        $clone->fileContent .= $this->creator->open();

        // add traits
        if (count($this->traits) !== 0) {
            $clone->fileContent .= $this->creator->createTraits($this->traits);
        }

        // add vars
        if (count($this->vars) !== 0) {
            $string = $this->creator->createVariables($this->vars);
            $clone->fileContent .= $string;
        }

        // add methods
        if (count($this->methods) !== 0) {
            $string = $this->creator->createMethods($this->methods);
            $clone->fileContent .= $string;
        }

        // add close to class
        $clone->fileContent .= $this->creator->close();

        // return class template
        return $clone;
    }
}
