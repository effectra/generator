<?php

declare(strict_types=1);

namespace Effectra\Generator;

use Effectra\ToString\ArrayToString;

/**
 * Class Creator
 *
 * This class provides methods for generating PHP code snippets.
 */
class Creator
{
    /**
     * Starts the PHP code.
     *
     * @return string The PHP opening tag.
     */
    public function start()
    {
        return "<?php\n";
    }

    /**
     * Generates a line break.
     *
     * @return string A line break character.
     */
    public function br()
    {
        return "\n";
    }

    /**
     * Generates the "declare(strict_types=1);" statement.
     *
     * @return string The declare statement.
     */
    public function declare()
    {
        return "\ndeclare(strict_types=1);\n\n";
    }

    /**
     * Creates the start of a class declaration.
     *
     * @param string $className The name of the class.
     * @return string The class declaration.
     */
    public function createClassStart(string $className): string
    {
        return sprintf("\nclass %s", $className);
    }

    /**
     * Creates an opening brace.
     *
     * @return string The opening brace.
     */
    public function open(): string
    {
        return "\n{";
    }

    /**
     * Creates a closing brace.
     *
     * @return string The closing brace.
     */
    public function close(): string
    {
        return "}\n";
    }

    /**
     * Generates indentation.
     *
     * @param int $times The number of indentation levels.
     * @return string The indentation string.
     */
    public function tab(int $times = 1): string
    {
        $string = '';
        for ($__i__ = 0; $__i__ < $times; $__i__++) {
            $string .= "\t";
        }
        return $string;
    }

    /**
     * Creates the end of a class declaration.
     *
     * @param string $className The name of the class.
     * @return string The class declaration end.
     */
    public function createClassEnd(string $className): string
    {
        $classContents = sprintf("\n}\n", $className);

        return $classContents;
    }

    /**
     * Creates a function declaration.
     *
     * @param string $name     The name of the function.
     * @param string $args     The function arguments.
     * @param string|null $return (optional) The return type of the function.
     * @param string $content (optional) The content of the function.
     * @return string The function declaration.
     */
    public function createFunction(string $name, string $args, string $return = null, string $content = '//'): string
    {
        $return_string = $return ? ': ' . $return : '';
        return sprintf("function %s(%s)%s {\n\t%s\n}", $name, $args, $return_string, $content);
    }

    /**
     * Creates a method declaration.
     *
     * @param string $typeFunction (optional) The visibility type of the method (e.g., public, private).
     * @param bool $static (optional) Indicates if the method is static.
     * @param string $name The name of the method.
     * @param array $args (optional) The method arguments.
     * @param string|null $return (optional) The return type of the method.
     * @param string $content (optional) The content of the method.
     * @return string The method declaration.
     */
    public function createMethod(
        string $typeFunction = 'public',
        bool $static = false,
        string $name,
        array $args = [],
        string $return = null,
        string $content = '//'
    ) {
        $args_string = $this->createArguments($args);
        $fn = $this->createFunction($name, $args_string, $return, $content);
        $static_string = $static ? ' static' : '';

        $method_string = sprintf("\n\t%s%s %s\n", $typeFunction, $static_string, $fn);

        $method_string = str_replace('}', "\t}", $method_string);

        return $method_string;
    }

    /**
     * Creates a method declaration with content.
     *
     * @param string $typeFunction (optional) The visibility type of the method (e.g., public, private).
     * @param bool $static (optional) Indicates if the method is static.
     * @param string $name The name of the method.
     * @param array $args (optional) The method arguments.
     * @param string|null $return (optional) The return type of the method.
     * @param string $content The content of the method.
     * @return string The method declaration with content.
     */
    public function createMethodWithContent(
        string $typeFunction = 'public',
        bool $static = false,
        string $name,
        array $args = [],
        string $return = null,
        string $content
    ) {
        $m = $this->createMethod(...func_get_args());

        return str_replace('//', $content, $m);
    }

    /**
     * Creates a variable declaration.
     *
     * @param string $type         (optional) The visibility type of the variable (e.g., public, private).
     * @param string $name         The name of the variable.
     * @param string $typeVar      (optional) The type of the variable.
     * @param bool $static         (optional) Indicates if the variable is static.
     * @param mixed $defaultValue (optional) The default value of the variable.
     * @return string The variable declaration.
     */
    public function createVariable(
        string $type = 'protected',
        string $name,
        string $typeVar = '',
        bool $static = false,
        mixed $defaultValue = '--'
    ) {
        $static_ = $static ? 'static ' : '';
        $defaultValue_ = $defaultValue !== '--' ? sprintf(' = %s', $this->changeTypeToString($defaultValue)) : '';
        return sprintf("\n\t%s %s%s $%s%s;\n", $type, $static_, $typeVar, $name, $defaultValue_);
    }

    /**
     * Creates a constant declaration.
     *
     * @param string $type         (optional) The visibility type of the constant (e.g., public, private).
     * @param string $name         The name of the constant.
     * @param string $typeVar      (optional) The type of the constant.
     * @param bool $static         (optional) Indicates if the constant is static.
     * @param mixed $defaultValue (optional) The default value of the constant.
     * @return string The constant declaration.
     */
    public function createConst(
        string $type = 'protected',
        string $name,
        string $typeVar = '',
        bool $static = false,
        mixed $defaultValue = null
    ) {
        $static_ = $static ? 'static ' : '';
        $defaultValue_ = $defaultValue ? sprintf(' = %s', $defaultValue) : '';
        return sprintf("%s %s CONST $%s %s;", $type, $static_, $typeVar, $name, $defaultValue_);
    }

    /**
     * Creates multiple variable declarations.
     *
     * @param array $vars An array of variables.
     * @return string The variable declarations.
     */
    public function createVariables(array $vars): string
    {
        $vars_string = '';

        foreach ($vars as $var) {
            $vars_string .= $this->createVariable(
                $var['type'],
                $var['name'],
                $var['typeVar'],
                $var['static'],
                $var['defaultValue'],
            );
        }

        return $vars_string;
    }

    /**
     * Creates multiple method declarations.
     *
     * @param array $methods An array of methods.
     * @return string The method declarations.
     */
    public function createMethods(array $methods): string
    {
        $methods_string = '';

        foreach ($methods as $method) {
            $methods_string .= $this->createMethod(
                $method['typeFunction'],
                $method['static'],
                $method['name'],
                $method['args'],
                $method['return'],
                $method['content'],
            );
        }

        return $methods_string;
    }

    /**
     * Creates a namespace declaration.
     *
     * @param string $namespace The namespace.
     * @return string The namespace declaration.
     */
    public function createNamespace(string $namespace): string
    {
        return sprintf("\nnamespace %s;\n\n", $namespace);
    }

    /**
     * Creates multiple "use" statements.
     *
     * @param array $packages An array of packages.
     * @return string The "use" statements.
     */
    public function createPackages(array $packages): string
    {
        $packages_string = '';
        foreach ($packages as $package) {
            $packages_string .= sprintf("use %s;\n", $package);
        }
        return $packages_string;
    }

    /**
     * Creates multiple trait "use" statements.
     *
     * @param array $traits An array of traits.
     * @return string The trait "use" statements.
     */
    public function createTraits(array $traits): string
    {
        $traits_string = '';
        $traits_string .= $this->tab();
        foreach ($traits as $trait) {
            $traits_string .= sprintf("use %s;", $trait);
        }
        $traits_string = sprintf("\n%s\n", $traits_string);
        return $traits_string;
    }

    /**
     * Creates an "extends" statement.
     *
     * @param string $className The name of the class to extend.
     * @return string The "extends" statement.
     */
    public function createExtends(string $className): string
    {
        return sprintf(" extends %s", $className);
    }

    /**
     * Creates an "implements" statement.
     *
     * @param string $interface The name of the interface to implement.
     * @return string The "implements" statement.
     */
    public function createImplements(string $interface): string
    {
        return sprintf(" implements %s", $interface);
    }

    /**
     * Creates an argument declaration.
     *
     * @param string|null $type         (optional) The type of the argument.
     * @param string      $name         The name of the argument.
     * @param mixed|null  $defaultValue (optional) The default value of the argument.
     * @return string The argument declaration.
     */
    public function createArgument(string $type = null, string $name, mixed $defaultValue = null): string
    {
        $argument = $type ? "$type $" . $name : "$" . $name;

        if ($defaultValue !== null) {
            $defaultValueString = $this->changeTypeToString($defaultValue);
            $argument .= " = $defaultValueString";
        }

        return $argument;
    }

    /**
     * Creates multiple argument declarations.
     *
     * @param array $args An array of arguments.
     * @return string The argument declarations.
     */
    public function createArguments(array $args): string
    {
        $args_string = '';

        foreach ($args as $arg) {
            $args_string .= $this->createArgument($arg['type'], $arg['name'], $arg['defaultValue']) . ', ';
        }

        return rtrim($args_string, ', ');
    }

    /**
     * Converts a variable to its string representation.
     *
     * @param mixed $value The value to convert.
     * @return string The string representation of the value.
     */
    public function changeTypeToString(mixed $value): string
    {
        if (is_string($value)) {
            return sprintf('"%s"', addslashes($value));
        } elseif (is_array($value)) {
            return ArrayToString::array($value);
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_null($value)) {
            return 'null';
        }

        return (string) $value;
    }
}
