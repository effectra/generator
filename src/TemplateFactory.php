<?php

declare(strict_types=1);

namespace Effectra\Generator;

/**
 * Class TemplateFactory
 *
 * This class represents a factory for creating templates.
 */
class TemplateFactory
{
    /**
     * Create a new template instance.
     *
     * @param string|null $namespace The namespace for the template.
     * @param array $packages The packages to include in the template.
     * @param array $methods The methods to include in the template.
     * @param array $traits The traits to include in the template.
     *
     * @return Template The created template instance.
     */
    public function createTemplate(string $namespace = null, array $packages = [], array $methods = [], array $traits = []): Template
    {
        return new Template($namespace, $packages, $methods, $traits);
    }
}
