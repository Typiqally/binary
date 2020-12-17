<?php

namespace Typiqally\Binary;

use InvalidArgumentException;

class BinarySerializer
{
    /**
     * @param string $class
     * @param string $value
     * @param BinarySerializerOptions|null $options
     *
     * @return BinaryModel
     * @throws Exceptions\BinaryConverterNotFoundException
     */
    public static function deserialize(string $class, string $value, ?BinarySerializerOptions $options = null): BinaryModel
    {
        $options ??= BinarySerializerOptions::getDefault();
        $model = new $class();

        if (!$model instanceof BinaryModel) {
            throw new InvalidArgumentException('Cannot deserialize to non-BinaryModel objects, please extend the BinaryModel class');
        }

        $read = 0;

        foreach ($model->getFields() as $name => $meta) {
            $type = array_key_first($meta);
            $length = $meta[$type];

            if ($length == '*') {
                $length = strlen($value);
            }

            $slice = substr($value, $read, $length);
            $read += $length;

            $model->$name = $options
                ->findConverter($type)
                ->read($type, $slice);
        }

        return $model;
    }

    /**
     * @param BinaryModel $model
     * @param BinarySerializerOptions|null $options
     *
     * @return string
     * @throws Exceptions\BinaryConverterNotFoundException
     */
    public static function serialize(BinaryModel $model, ?BinarySerializerOptions $options = null): string
    {
        $options ??= BinarySerializerOptions::getDefault();
        $data = '';

        foreach ($model->getFields() as $name => $meta) {
            $type = array_key_first($meta);
            $length = $meta[$type];

            if ($length == '*') {
                $length = strlen($model->$name);
            }

            $data .= $options
                ->findConverter($type)
                ->write($type, $length, $model->$name);
        }

        return $data;
    }
}
