<?php namespace Moelanz\Serializer;

/**
 * Class FormatInterface
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
interface FormatInterface
{
    /**
     * @return string
     */
    public function convert(): string;

    /**
     * @param $string
     * @return mixed
     */
    public function deconvert($string);

    /**
     * @param array $data
     */
    public function setData(array $data): void;
}