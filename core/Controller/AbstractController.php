<?php namespace Moelanz\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AbstractController
 * @package Moelanz\Controller
 *
 * @author Moelanz
 */
abstract class AbstractController
{
    /**
     * Twig Engine
     *
     * @var Environment
     */
    private $twig;

    /**
     * AbstractController Constructor
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render twig template
     *
     * @param string $template
     * @param array $context
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }
}