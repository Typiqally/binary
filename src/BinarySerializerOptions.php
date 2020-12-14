<?php

namespace Typiqally\Binary;

use Typiqally\Binary\Converters\BinaryDateTimeConverter;
use Typiqally\Binary\Converters\BinaryHexadecimalConverter;
use Typiqally\Binary\Converters\BinaryNumericConverter;
use Typiqally\Binary\Converters\BinaryRawConverter;
use Typiqally\Binary\Exceptions\BinaryConverterNotFoundException;
use Generator;

class BinarySerializerOptions
{
    private static BinarySerializerOptions $default;

    private array $converters = [];

    /**
     * @return BinarySerializerOptions
     */
    public static function getDefault(): self
    {
        if (!isset(self::$default)) {
            self::$default = new BinarySerializerOptions();
        }

        return self::$default;
    }

    /**
     * @param BinaryConverter $converter
     *
     * @return BinarySerializerOptions
     */
    public function addConverter(BinaryConverter $converter): self
    {
        array_push($this->converters, $converter);

        return $this;
    }

    /**
     * @param string $type
     *
     * @return BinaryConverter
     * @throws BinaryConverterNotFoundException
     */
    public function findConverter(string $type): BinaryConverter
    {
        foreach ($this->converters as $converter) {
            if ($converter->canConvert($type)) {
                return $converter;
            }
        }

        foreach ($this->defaultConverters() as $converter) {
            if ($converter->canConvert($type)) {
                return $converter;
            }
        }

        throw new BinaryConverterNotFoundException($type);
    }

    private function defaultConverters(): Generator
    {
        yield new BinaryNumericConverter();
        yield new BinaryRawConverter();
        yield new BinaryHexadecimalConverter();
        yield new BinaryDateTimeConverter();
    }
}
