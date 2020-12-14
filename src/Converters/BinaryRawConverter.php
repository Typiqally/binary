<?php

namespace Typiqally\Binary\Converters;

use Typiqally\Binary\BinaryConverter;

class BinaryRawConverter implements BinaryConverter
{

    public function canConvert(string $type): bool
    {
        return $type == 'raw';
    }

    public function read(string $type, int $length, $value)
    {
        return $value;
    }

    public function write(string $type, int $length, $value): string
    {
        return $value;
    }
}
