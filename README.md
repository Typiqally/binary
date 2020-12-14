# PHP Binary Serializer

This package aims to help create structured models for binary data. For example, this can be used to provide a structured way to (de)serialize incoming and outgoing TCP data or other for other binary related use-cases.

## Note

This project is currently under development and still in an alpha stage.

## Installation

The package can be installed by executing the following command:

```
composer require typiqally/binary
```

## Model

Structured binary models are created like this:

```php
use Typiqally\Binary\BinaryModel;

class Packet extends BinaryModel
{
    public array $fields = [
        //Name => [Type, Expected length],
        'magic' => ['raw', 4],
        'protocol' => ['numeric', 1],
        'length' => ['numeric', 2],
    ];
}
```

### Usage

When the model is created, serializing is very easy. The constructor is automatically created and can be inherited if
required. Just construct your model like this:

```php
$model = new Packet("\x12\x34\x56\x78", 10, 1337);
```

#### Serialization

To serialize your model to binary, simply call the following function:

```php
$value = BinarySerializer::serialize($model);
//Output (converted to hex using bin2hex): 123456780a0539
```

#### Deserialization

To deserialize your binary to a model, you can call the following function:

```php
$model = BinarySerializer::deserialize(Packet::class, $value);
//Output (by using the internal __toString function): magic=%124Vx, protocol=10, length=1337
```

## License

This project is licensed under the GPL-3.0 license.
See [LICENSE.md](https://github.com/Typiqally/binary/blob/master/LICENSE.md) for the full license text.
