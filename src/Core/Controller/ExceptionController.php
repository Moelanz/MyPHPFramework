<?php
namespace App\Core\Controller;

class ExceptionController
{
    public function httpNotFound($uri): string
    {
        return 'Page ' . $uri . ' not found';
    }

    public function serviceNotFound($name): string
    {
        return 'Service ' . $name . ' not found';
    }
}