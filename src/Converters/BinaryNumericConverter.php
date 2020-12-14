<?php

namespace Typiqally\Binary\Converters;

use Typiqally\Binary\BinaryConverter;

class BinaryNumericConverter implements BinaryConverter
{
    public function canConvert(string $type): bool
    {
        return $type == 'numeric';
    }

    public function read(string $type, int $length, $value)
    {
        return hexdec(bin2hex($value));
    }

    public function write(string $type, int $length, $value): string
    {
        return hex2bin(str_pad(dechex($value), $length * 2, '0', STR_PAD_LEFT));
    }
}
