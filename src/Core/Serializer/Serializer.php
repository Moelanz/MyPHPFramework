<?php
namespace App\Core\Serializer;

class Serializer
{
    public function serialize($data, FormatInterface $format): string
    {
        $format->setData($data);
        return $format->convert();
    }
}