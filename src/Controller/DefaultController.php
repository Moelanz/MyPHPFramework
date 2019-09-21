<?php
namespace App\Controller;

use App\Annotations\Route;
use Twig\Environment;

/**
 * Class DefaultController
 * @package App\Controller
 *
 * @Route(route="/")
 */
class DefaultController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route(route="/")
     */
    public function index(): string
    {
        return $this->twig->render('base.html.twig');
    }
}