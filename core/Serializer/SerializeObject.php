<?php namespace Moelanz\Serializer;

/**
 * Class SerializeObject
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
class SerializeObject implements FormatNameInterface, FormatInterface, DeconvertInterface
{
    /**
     * @return string
     */
    public function convert(): string
    {
        // TODO: Implement convert() method.
    }

    /**
     * @param $string
     * @return mixed|void
     */
    public function deconvert($string)
    {
        // TODO: Implement deconvert() method.
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        // TODO: Implement setData() method.
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }
}
