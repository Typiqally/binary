<?php

namespace Typiqally\Binary;

use InvalidArgumentException;

class BinarySerializer
{
    /**
     * @param BinaryModel $model
     * @param BinarySerializerOptions|null $options
     *
     * @return string
     * @throws Exceptions\BinaryConverterNotFoundException
     */
    public static function serialize(BinaryModel $model, ?BinarySerializerOptions $options = null): string
    {
        $options ??= new BinarySerializerOptions();
        $data = '';

        foreach ($model->fields as $name => $info) {
            $type = $info[0];
            $length = $info[1];

            $data .= $options->findConverter($type)->write($type, $length, $model->$name);
        }

        return $data;
    }

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
        $model = new $class();
        if (!$model instanceof BinaryModel) {
            throw new InvalidArgumentException('Cannot deserialize to non-BinaryModel objects, please extend the BinaryModel class');
        }

        $options ??= new BinarySerializerOptions();

        foreach ($model->fields as $name => $info) {
            $type = $info[0];
            $length = $info[1];

            $slice = substr($value, 0, $length);
            $value = substr($value, $length);

            $model->$name = $options->findConverter($type)->read($type, $length, $slice);
        }

        return $model;
    }
}
