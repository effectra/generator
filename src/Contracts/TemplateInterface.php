<?php

declare(strict_types=1);

namespace Effectra\Generator\Contracts;


/**
 * Interface TemplateInterface
 *
 * This interface defines the methods for generating and manipulating code templates.
 */
interface TemplateInterface
{
    /**
     * Get the namespace of the template.
     *
     * @return string The namespace.
     */
    public function getNameSpace(): string;

    /**
     * Get the packages used by the template.
     *
     * @return array The packages.
     */
    public function getPackages(): array;

    /**
     * Get the variables defined in the template.
     *
     * @return array The variables.
     */
    public function getVars(): array;

    /**
     * Get the constants defined in the template.
     *
     * @return array The constants.
     */
    public function getConsts(): array;

    /**
     * Get the methods defined in the template.
     *
     * @return array The methods.
     */
    public function getMethods(): array;

    /**
     * Get the traits used by the template.
     *
     * @return array The traits.
     */
    public function getTraits(): array;

    /**
     * Get the content of the template file.
     *
     * @return string The file content.
     */
    public function getFileContent(): string;

    /**
     * Set the namespace of the template.
     *
     * @param string $namespace The namespace.
     * @return TemplateInterface The updated template instance.
     */
    public function withNameSpace(string $namespace): self;

    /**
     * Set the extends class for the template.
     *
     * @param string $className The class name to extend.
     * @return TemplateInterface The updated template instance.
     */
    public function withExtends(string $className): self;

    /**
     * Set the interfaces implemented by the template.
     *
     * @param string $interface The interface to implement.
     * @return TemplateInterface The updated template instance.
     */
    public function withImplements(string $interface): self;

    /**
     * Set the packages used by the template.
     *
     * @param array $packages The packages to use.
     * @return TemplateInterface The updated template instance.
     */
    public function withPackages(array $packages): self;

    /**
     * Set the variables defined in the template.
     *
     * @param array $vars The variables to define.
     * @return TemplateInterface The updated template instance.
     */
    public function withVars(array $vars): self;

    /**
     * Add a variable to the template.
     *
     * @param array $var The variable to add.
     * @return TemplateInterface The updated template instance.
     */
    public function withVar(array $var): self;

    /**
     * Add a variable to the template.
     *
     * @param string $type The visibility of the variable (protected, private, public).
     * @param string $name The name of the variable.
     * @param string $typeVar The type of the variable.
     * @param bool $static Whether the variable is static or not.
     * @param mixed|null $defaultValue The default value of the variable.
     * @return TemplateInterface The updated template instance.
     */
    public function withVariable(string $type = 'protected', string $name, string $typeVar = 'mixed', bool $static = false, mixed $defaultValue = null): self;

    /**
     * Set the constants defined in the template.
     *
     * @param array $consts The constants to define.
     * @return TemplateInterface The updated template instance.
     */
    public function withConsts(array $consts): self;



    /**
     * Set the constants defined in the template.
     *
     * @param array $const The constants to define.
     * @return TemplateInterface The updated template instance.
     */
    public function withConst(array $const): self;

    /**
     * Add a constant to the template.
     *
     * @param string $type The visibility of the constant (protected, private, public).
     * @param string $name The name of the constant.
     * @param string $typeVar The type of the constant.
     * @param bool $static Whether the constant is static or not.
     * @param mixed|null $defaultValue The default value of the constant.
     * @return TemplateInterface The updated template instance.
     */
    public function withConstant(string $type = 'protected', string $name, string $typeVar = 'mixed', bool $static = false, mixed $defaultValue = null): self;

    /**
     * Set the methods defined in the template.
     *
     * @param array $methods The methods to define.
     * @return TemplateInterface The updated template instance.
     */
    public function withMethods(array $methods): self;

    /**
     * Add a method to the template.
     *
     * @param string $typeFunction The type of the method (public, protected, private).
     * @param bool $static Whether the method is static or not.
     * @param string $name The name of the method.
     * @param array $args The arguments of the method.
     * @param string $return The return type of the method.
     * @return TemplateInterface The updated template instance.
     */
    public function withMethod(string $typeFunction = 'public', bool $static = false, string $name, array $args, string $return,string $content = '//');

    /**
     * Set the arguments for a method.
     *
     * @param string $methodName The name of the method.
     * @param array $args The arguments of the method.
     * @return TemplateInterface The updated template instance.
     */
    public function withArguments(string $methodName, array $args): self;

    /**
     * Add an argument to a method.
     *
     * @param string $methodName The name of the method.
     * @param string $type The type of the argument.
     * @param string $name The name of the argument.
     * @param mixed $defaultValue The default value of the argument.
     * @return TemplateInterface The updated template instance.
     */
    public function withArgument(string $methodName, string $type, string $name, $defaultValue = '--'): self;

    /**
     * Set the traits used by the template.
     *
     * @param array $traits The traits to use.
     * @return TemplateInterface The updated template instance.
     */
    public function withTraits(array $traits): self;

    /**
     * Set the content of the template file.
     *
     * @param string $content The content of the file.
     * @return TemplateInterface The updated template instance.
     */
    public function withContentFile(string $content): self;

    /**
     * Find a method in the template by its name.
     *
     * @param string $name The name of the method to find.
     * @return array|null The method details if found, null otherwise.
     */
    public function findMethod(string $name): array|null;

    /**
     * Generate the template and return a new instance of TemplateInterface.
     *
     * @return TemplateInterface A new instance of the generated template.
     */
    public function generate(): TemplateInterface;

    /**
     * Save the template to a file.
     *
     * @param string $path The path to save the template file.
     * @return int|false The number of bytes written on success, false on failure.
     */
    public function save(string $path): int|false;
}
