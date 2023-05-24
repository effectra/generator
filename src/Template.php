<?php

declare(strict_types=1);

namespace Effectra\Generator;

use Effectra\Fs\File;
use Effectra\Generator\Contracts\TemplateInterface;

class Template implements TemplateInterface
{

    protected $namespace;

    protected $extends;

    protected $implements;

    protected $packages = [];

    protected $vars = [];

    protected $consts = [];

    protected $methods = [];

    protected $traits = [];

    protected $fileContent = "";

    public function __construct(string $namespace = null, array $packages = [], array $vars = [], array $consts = [], array $methods = [], array $traits = [])
    {
        $this->namespace = $namespace;
        $this->packages = $packages;
        $this->vars = $vars;
        $this->consts = $consts;
        $this->methods = $methods;
        $this->traits = $traits;
    }

    public function getNameSpace(): string
    {
        return $this->namespace;
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function getConsts(): array
    {
        return $this->consts;
    }


    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getTraits(): array
    {
        return $this->traits;
    }

    public function getFileContent(): string
    {
        return $this->fileContent;
    }

    public function withNameSpace(string $namespace): self
    {
        $clone = clone $this;
        $clone->namespace = $namespace;
        return $clone;
    }

    public function withExtends(string $className): self
    {
        $clone = clone $this;
        $clone->extends = $className;
        return $clone;
    }

    public function withImplements(string $interface): self
    {
        $clone = clone $this;
        $clone->implements = $interface;
        return $clone;
    }

    public function withPackages(array $packages): self
    {
        $clone = clone $this;
        $clone->packages = $packages;
        return $clone;
    }

    public function withVars(array $vars): self
    {
        $clone = clone $this;
        $clone->vars = $vars;
        return $clone;
    }

    public function withVar(array $var): self
    {
        $clone = clone $this;
        $clone->vars[] = $var;
        return $clone;
    }

    public function withVariable(string $type = 'protected', string $name, string $typeVar = 'mixed', bool $static = false, mixed $defaultValue = null): self
    {
        $clone = clone $this;
        $clone->vars[] = [
            'type' => $type,
            'name' => $name,
            'typeVar' => $typeVar,
            'static' => $static,
            'defaultValue' => $defaultValue,
        ];
        return $clone;
    }

    public function withConsts(array $consts): self
    {
        $clone = clone $this;
        $clone->consts = $consts;
        return $clone;
    }

    public function withConst(array $const): self
    {
        $clone = clone $this;
        $clone->consts[] = $const;
        return $clone;
    }

    public function withConstant(string $type = 'protected', string $name, string $typeVar = 'mixed', bool $static = false, mixed $defaultValue = null): self
    {
        $clone = clone $this;
        $clone->consts[] = [
            'type' => $type,
            'name' => $name,
            'typeVar' => $typeVar,
            'static' => $static,
            'defaultValue' => $defaultValue,
        ];
        return $clone;
    }

    public function withMethods(array $methods): self
    {
        $clone = clone $this;
        $clone->methods = $methods;
        return $clone;
    }

    public function withMethod(string $typeFunction = 'public', bool $static = false, string $name, array $args, string $return,string $content = '//')
    {
        $clone = clone $this;
        $clone->methods[] = [
            'typeFunction' => $typeFunction,
            'static' => $static,
            'name' => $name,
            'args' => $args,
            'return' => $return,
            'content' => $content
        ];

        return $clone;
    }
    

    public function findMethod(string $name): array|null
    {
        foreach ($this->methods as $item) {
            if ($item['name'] == $name) {
                return $item;
            }
        }
        return null;
    }

    public function withArguments(string $methodName, array $args): self
    {
        $method = $this->findMethod($methodName);
        if (!$method) {
            $method['args'] = $args;
        }
        return $this;
    }

    public function withArgument(string $methodName, string $type, string $name, mixed $defaultValue = '--'): self
    {
        $clone = clone $this;

        foreach ($clone->methods as $method) {

            if ($method['name'] === $methodName) {

                $methodClone = $method;

                $methodClone['args'][] =  [
                    'type' =>  $type,
                    'name' =>  $name,
                    'defaultValue' => $defaultValue = '--' ? $defaultValue : '',
                ];
                array_shift($clone->methods);
                $clone->methods[] = $methodClone;
            }
        }

        return $clone;
    }

    public function withTraits(array $traits): self
    {
        $clone = clone $this;
        $clone->traits = $traits;
        return $clone;
    }
    public function withContentFile(string $content): self
    {
        $clone = clone $this;
        $clone->fileContent = $content;
        return $clone;
    }


    public function generate(): TemplateInterface
    {
        return $this;
    }

    public function save(string $path): int|false
    {
        return File::put($path, $this->fileContent);
    }
}
