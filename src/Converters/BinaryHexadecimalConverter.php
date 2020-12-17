<?php

namespace Typiqally\Binary\Converters;

use Typiqally\Binary\BinaryConverter;

class BinaryHexadecimalConverter implements BinaryConverter
{
    public function canConvert(string $type): bool
    {
        return $type == 'hex';
    }

    public function read(string $type, $value): string
    {
        return bin2hex($value);
    }

    public function write(string $type, int $length, $value): string
    {
        return hex2bin(str_pad($value, $length * 2, '0', STR_PAD_LEFT));
    }
}
