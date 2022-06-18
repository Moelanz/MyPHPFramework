<?php namespace Moelanz\Controller;

use Moelanz\Logger\Logger;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ExceptionController
 * @package Moelanz\Controller
 *
 * @author Moelanz
 */
class ExceptionController extends AbstractController
{
    /**
     * 404 not found
     *
     * @param $uri
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function httpNotFound($uri): string
    {
        (new Logger())
            ->setInstance('404')
            ->log('Page ' . $uri . ' not found');
        return $this->render('error/404.php.twig');
    }

    /**
     * Fatal error
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function fatal(): string
    {
        return $this->render('error/error.php.twig');
    }

    /**
     * Fatal error
     *
     * @param $name
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function serviceNotFound($name): string
    {
        (new Logger())
            ->setInstance('service')
            ->log('Service ' . $name . ' not found');
        return $this->render('error/error.php.twig');
    }
}
