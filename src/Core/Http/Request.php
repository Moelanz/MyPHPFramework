<?php
namespace App\Core\Http;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function getIp(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getServerPort(): int
    {
        return $_SERVER['SERVER_PORT'];
    }

    public function getQuery($name): ?string
    {
        return $_GET[$name] ?? null;
    }

    public function getPost($name): ?string
    {
        return $_POST[$name] ?? null;
    }

    public function getContent(): string
    {
        return file_get_contents('php://input');
    }
}