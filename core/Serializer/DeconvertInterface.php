<?php namespace Moelanz\Serializer;

/**
 * Interface DeconvertInterface
 * @package Moelanz\Serializer
 *
 * @author Moelanz
 */
interface DeconvertInterface
{
    /**
     * @param $string
     * @return mixed
     */
    public function deconvert($string);
}