<?php
namespace App\Controller;

use App\Core\Annotations\Route;
use App\Core\Http\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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

    /**
     * @var Request
     */
    private $request;

    public function __construct(Environment $twig, Request $request)
    {
        $this->twig = $twig;
        $this->request = $request;
    }

    /**
     * @Route(route="/")

     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): string
    {
        return $this->twig->render('base.html.twig', [
            'name' => 'John Doe',
            'method' => $this->request->getMethod(),
            'ip' => $_SERVER['REMOTE_ADDR'],
        ]);
    }

    /**
     * @Route("request")
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function requestTest(): string
    {
        return $this->twig->render('request.html.twig', [
            'request' => $this->request,
        ]);
    }
}