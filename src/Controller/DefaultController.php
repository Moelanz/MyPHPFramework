<?php namespace App\Controller;

use Moelanz\Annotations\Route;
use Moelanz\Controller\AbstractController;
use Moelanz\Http\Request;
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
class DefaultController extends AbstractController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Environment $twig
     * @param Request $request
     */
    public function __construct(Environment $twig, Request $request)
    {
        parent::__construct($twig);
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
        return $this->render('base.html.twig', [
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
        return $this->render('request.html.twig', [
            'request' => $this->request,
        ]);
    }
}