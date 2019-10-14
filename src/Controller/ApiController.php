<?php
namespace App\Controller;

use App\Core\Annotations\Route;
use App\Core\Http\Request;
use App\Core\Serializer\Serializer;
use App\Core\Serializer\XML;
use App\Entity\User;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Request $request, Serializer $serializer)
    {
        $this->request = $request;
        $this->serializer = $serializer;
    }

    /**
     * @return string
     * @Route("/api/test", method="POST")
     */
    public function post()
    {
        /**
         * @var User $user
         */
        $content = $this->serializer->deserialize($this->request->getContent());

        dump($user->getUsername());
    }

    /**
     * @return string
     * @Route("/api/test", method="GET")
     */
    public function get(): string
    {
        return $this->serializer->serialize([
            'user1' => [
                'username' => 'Moelanz',
                'password' => '***********',
                'posts' => [
                    'id' => 1
                ]
            ],
            'user2' => [
                'username' => 'Moelanz',
                'password' => '***********',
            ]
        ], new XML());
    }
}