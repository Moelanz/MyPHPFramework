<?php
namespace App\Core\Annotations;

use App\Core\Http\Request;

/**
 * Class Route
 * @package App\Annotations
 *
 * @Annotation
 */
class Route
{
    public $route;
    public $method = 'ANY';
}