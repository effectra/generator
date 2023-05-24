<?php

declare(strict_types=1);

namespace Effectra\Generator;

use Effectra\Config\ConfigFile;
use Effectra\Config\Exception\ConfigFileException;
use Effectra\Fs\File;
use Effectra\Fs\Type\Php;
use Effectra\Generator\Contracts\TemplateInterface;

/**
 * Class GeneratorConfigFile
 *
 * This class represents a generator for config files.
 */
class GeneratorConfigFile extends Template
{
    /**
     * GeneratorConfigFile constructor.
     *
     * @param Creator $creator
     * @param ConfigFile $configFile
     */
    public function __construct(
        protected Creator $creator,
        protected ConfigFile $configFile
    ) {
    }

    /**
     * Create a new section in the config file.
     *
     * @param string $section The section name.
     * @param array $config The section configuration.
     *
     * @throws ConfigFileException if the section already exists.
     *
     * @return TemplateInterface The generated template.
     */
    public function createSection(string $section, array $config): TemplateInterface
    {
        if (in_array($section, $this->configFile->getSections())) {
            throw new ConfigFileException("Section already exists");
        }

        $section_config = sprintf(",\n    '%s' => %s    \n", $section, Php::toArray($config));

        $config_file_string = File::getContent($this->configFile->getFile(), null);

        $replace = $section_config . "];";

        $new_config_file_string = str_replace("];", $replace, $config_file_string);

        return $this->withContentFile($new_config_file_string);
    }

    /**
     * Generate the template.
     *
     * @return TemplateInterface The generated template.
     */
    public function generate(): TemplateInterface
    {
        return  $this->withContentFile("<?php\ndeclare(strict_types=1);\n\nreturn [\n\n];");
    }

    /**
     * Save the generated file.
     *
     * @param string $filePath The path to save the file to.
     *
     * @return int|false The number of bytes written or false on failure.
     */
    public function save(string $filePath): int|false
    {
        return File::put($filePath, $this->getFileContent());
    }
}
