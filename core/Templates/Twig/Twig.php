<?php namespace Moelanz\Templates\Twig;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Twig
 * @package Moelanz\templates\Twig
 *
 * @author Moelanz
 */
class Twig
{
    /**
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * Twig Constructor
     */
    public function __construct(string $templatePath = __DIR__.'/../../../templates')
    {
        $this->loader = new FilesystemLoader($templatePath);
    }

    /**
     * Get Twig Environment
     *
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        if (is_null($this->twig)) {
            $this->twig = new Environment($this->loader);
        }

        return $this->twig;
    }

    /**
     * Render
     *
     * @param string $template
     * @param array $context
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $context = []): string
    {
        return $this->getEnvironment()->render($template, $context);
    }
}