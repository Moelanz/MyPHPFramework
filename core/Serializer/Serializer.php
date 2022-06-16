<?php namespace Moelanz\Serializer;

/**
 * Class Serializer
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
class Serializer
{
    /**
     * @param $data
     * @param FormatInterface $format
     * @return string
     */
    public function serialize($data, FormatInterface $format): string
    {
        $format->setData($data);
        return $format->convert();
    }

    /**
     * @param $data
     * @return array
     */
    public function deserialize($data): array
    {
        $format = new JSON();
        return $format->deconvert($data);
    }
}