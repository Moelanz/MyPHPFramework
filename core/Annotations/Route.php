<?php namespace Moelanz\Annotations;

/**
 * Class Route
 * @package Moelanz\Annotations
 *
 * @author Moelanz
 *
 * @Annotation
 */
class Route
{
    /**
     * Router path
     *
     * @var string
     */
    public $route;

    /**
     * Router method
     *
     * @var string
     */
    public $method = 'ANY';

    /**
     * Router name
     *
     * @var string
     */
    public $name;
}