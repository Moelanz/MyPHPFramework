<?php
namespace App\Core\Serializer;

class Serializer
{
    public function serialize($data, FormatInterface $format): string
    {
        $format->setData($data);
        return $format->convert();
    }

    public function deserialize($data): array
    {
        $format = new JSON();
        return $format->deconvert($data);
    }
}