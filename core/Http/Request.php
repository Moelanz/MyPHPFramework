<?php namespace Moelanz\Http;

/**
 * Class Request
 * @package Moelanz\Http
 */
class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    /**
     * Get Method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get Ip
     *
     * @return string
     */
    public function getIp(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Get Server Port
     *
     * @return int
     */
    public function getServerPort(): int
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * Get Query Variable
     *
     * @param $name
     * @return string|null
     */
    public function getQuery($name): ?string
    {
        return $_GET[$name] ?? null;
    }

    /**
     * Get Post Variable
     *
     * @param $name
     * @return string|null
     */
    public function getPost($name): ?string
    {
        return $_POST[$name] ?? null;
    }

    /**
     * Get Content
     *
     * @return string
     */
    public function getContent(): string
    {
        return file_get_contents('php://input');
    }
}