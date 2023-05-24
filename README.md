# Effectra\Generator

The Effectra\Generator package provides a set of tools for generating PHP class files and configuration files.

## Installation

You can install the package via Composer:

```bash
composer require effectra/generator
```

## Usage

### Generate Class

To generate a PHP class file using the GeneratorClass class, follow these steps:

1. Create an instance of the Creator class:

```php
$creator = new Creator();
```

2. Create an instance of the GeneratorClass class, providing the creator and the desired class name:

```php
$generator = new GeneratorClass($creator, 'MyClass');
```

3. Customize the class by adding properties, methods, and other elements using the available methods provided by the GeneratorClass and Creator classes.

4. Generate the PHP code for the class:

```php
$template = $generator->generate();
```

5. Save the generated code to a file:

```php
$template->save('/path/to/MyClass.php');
```

### Generate Config File

To generate a configuration file using the GeneratorConfigFile class, follow these steps:

1. Create an instance of the Creator class:

```php
$creator = new Creator();
```

2. Create an instance of the GeneratorConfigFile class, providing the creator and the ConfigFile instance:

```php
$configFile = new ConfigFile('/path/to/config.php');
$generator = new GeneratorConfigFile($creator, $configFile);
```

3. Generate a new section in the configuration file:

```php
$section = 'database';
$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'mydatabase',
    'username' => 'myusername',
    'password' => 'mypassword',
];

$template = $generator->createSection($section, $config);
```

4. Save the updated configuration file:

```php
$template->save('/path/to/config.php');
```

## Contributing

Contributions are welcome! If you find any issues or would like to suggest new features, please open an issue on the [GitHub repository](https://github.com/effectra/generator).

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

