<?php
namespace App\Core\Annotations;

/**
 * Class Route
 * @package App\Core\Annotations
 *
 * @Annotation
 */
class Route
{
    public $route;
    public $method = 'ANY';
}