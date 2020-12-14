<?php

namespace Typiqally\Binary\Exceptions;

use Exception;

class BinaryConverterNotFoundException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("BinaryConverter for type '$type' not found");
    }
}
