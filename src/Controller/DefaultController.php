<?php
namespace App\Controller;

use App\Core\Annotations\Route;
use App\Core\Database\EntityManager;
use App\Core\Http\Request;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
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

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(Environment $twig, Request $request, UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->twig = $twig;
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
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
        /*$user = $this->userRepository->find(1);

        $post = new Post();
        $post->setAuthor($user->getId());
        $post->setContent('test');

        $this->postRepository->save($post);*/

        return $this->twig->render('base.html.twig', [
            'name' => 'John Doe',
            'method' => $this->request->getMethod(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'post' => $this->postRepository->find(1),
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