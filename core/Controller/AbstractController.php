<?php namespace Moelanz\Controller;

use Moelanz\Controller\Variables\DefaultVariables;
use Moelanz\FlashMessage\FlashBag;
use Moelanz\Http\Request;
use Moelanz\Templates\Twig\Twig;
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
     * Twig
     *
     * @var Twig|null
     */
    private ? Twig $twig = null;

    /**
     * FlashBag
     *
     * @var FlashBag|null
     */
    private ? FlashBag $flashBag = null;

    /**
     * Request
     *
     * @var Request|null
     */
    private ? Request $request = null;

    /**
     * Get FlashBag
     *
     * @return FlashBag
     */
    public function getFlashBag(): FlashBag
    {
        if (is_null($this->flashBag)) {
            $this->flashBag = new FlashBag();
        }

        return $this->flashBag;
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
        return $this->getTwig()->render($template, array_merge([
            'app' => (new DefaultVariables(
                $this->getRequest(),
                $this->getFlashBag()
            )),
        ], $context));
    }

    /**
     * Get request
     *
     * @return Request
     */
    protected function getRequest(): Request
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * @return Twig
     */
    private function getTwig(): Twig
    {
        if (is_null($this->twig)) {
            $this->twig = new Twig();
        }

        return $this->twig;
    }
}