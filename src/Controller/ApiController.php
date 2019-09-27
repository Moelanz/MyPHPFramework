<?php
namespace App\Controller;

use App\Core\Annotations\Route;
use App\Core\Http\Request;

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

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     * @Route("/api/test", method="POST")
     */
    public function post(): string
    {
        return $this->request->getMethod();
    }

    /**
     * @return string
     * @Route("/api/test", method="GET")
     */
    public function get(): string
    {
        return $this->request->getMethod();
    }
}