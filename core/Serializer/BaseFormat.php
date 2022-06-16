<?php namespace Moelanz\Serializer;

/**
 * Class BaseFormat
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
abstract class BaseFormat
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    abstract public function convert(): string;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->convert();
    }
}
