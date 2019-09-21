<?php
namespace App\Controller;

class ExceptionController
{
    public function httpNotFound($uri): string
    {
        return 'Page ' . $uri . ' not found';
    }
}