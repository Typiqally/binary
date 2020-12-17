<?php

namespace Typiqally\Binary\Converters;

use Typiqally\Binary\BinaryConverter;

class BinaryDecimalDegreesConverter implements BinaryConverter
{
    public function canConvert(string $type): bool
    {
        return $type == 'decimalDegrees';
    }

    public function read(string $type, $value)
    {
        return hexdec(bin2hex($value)) / 30000 / 60;
    }

    public function write(string $type, int $length, $value): string
    {
        $decimalDegrees = dechex($value * 60 * 30000);

        return hex2bin(str_pad($decimalDegrees, $length * 2, '0', STR_PAD_LEFT));
    }
}
