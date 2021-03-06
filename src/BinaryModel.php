<?php

namespace Typiqally\Binary;

abstract class BinaryModel
{
    protected array $fields = [];

    private array $properties = [];

    public function __construct(...$properties)
    {
        $fields = array_keys($this->fields);

        foreach ($properties as $index => $value) {
            $name = $fields[$index];
            $this->__set($name, $value);
        }
    }

    public function __get($name)
    {
        return $this->properties[$name];
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function __toString(): string
    {
        return http_build_query($this->properties, '', ', ');
    }
}
