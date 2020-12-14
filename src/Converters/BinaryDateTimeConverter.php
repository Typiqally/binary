<?php

namespace Typiqally\Binary\Converters;

use Typiqally\Binary\BinaryConverter;
use DateTime;

class BinaryDateTimeConverter implements BinaryConverter
{
    public function canConvert(string $type): bool
    {
        return $type == 'dateTime';
    }

    public function read(string $type, int $length, $value): DateTime
    {
        $epoch = dechex(bin2hex($value));

        return new DateTime("@$epoch");
    }

    public function write(string $type, int $length, $value): string
    {
        return hex2bin(str_pad(dechex($value->format('U')), 8, '0', STR_PAD_LEFT));
    }
}
