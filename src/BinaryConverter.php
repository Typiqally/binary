<?php

namespace Typiqally\Binary;

interface BinaryConverter
{
    public function canConvert(string $type): bool;

    public function read(string $type, $value);

    public function write(string $type, int $length, $value): string;
}
