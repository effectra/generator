<?php

declare(strict_types=1);

namespace Effectra\Generator;

class GeneratorDocBlock 
{
    public function createReturn(string $returnValue,string $document = '') :string
    {
        return sprintf("\n* @return %s %s\n ",$returnValue,$document);
    }

    public function createArgument(array $arguments) :string
    {
        $arg = '';
        foreach ($arguments as $argument) {
            $arg .= sprintf("* @param string %s\n ",$argument);
        }
        return $arg;
    }
}
