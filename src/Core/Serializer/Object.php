<?php
namespace App\Core\Serializer;

class Object implements FormatNameInterface, FormatInterface, DeconvertInterface
{
    public function convert(): string
    {
        // TODO: Implement convert() method.
    }

    public function deconvert($string)
    {
        // TODO: Implement deconvert() method.
    }

    public function setData(array $data): void
    {
        // TODO: Implement setData() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }
}