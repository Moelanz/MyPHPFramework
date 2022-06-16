<?php namespace Moelanz\Controller;

/**
 * Class ExceptionController
 * @package Moelanz\Controller
 *
 * @author Moelanz
 */
class ExceptionController
{
    /**
     * @param $uri
     * @return string
     */
    public function httpNotFound($uri): string
    {
        return 'Page ' . $uri . ' not found';
    }

    /**
     * @param $name
     * @return string
     */
    public function serviceNotFound($name): string
    {
        return 'Service ' . $name . ' not found';
    }
}
