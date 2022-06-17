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
     * @var bool
     */
    private $sanitize = true;

    /**
     * Set sanitizing
     *
     * @param bool $flag
     * @return $this
     */
    public function setSanitizing(bool $flag): self
    {
        $this->sanitize = $flag;
        return $this;
    }

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
     * @param string $name
     * @param mixed|null $default
     * @return string|null
     */
    public function getQuery(string $name, $default = null): ?string
    {
        if ( ! isset($_GET[$name])) {
            return $default;
        }

        return $this->sanitizeValue($_GET[$name]) ?? null;
    }

    /**
     * Get Post Variable
     *
     * @param string $name
     * @param mixed|null $default
     * @return string|null
     */
    public function getPost(string $name, $default = null): ?string
    {
        if ( ! isset($_POST[$name])) {
            return $default;
        }

        return $this->sanitizeValue($_POST[$name]);
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

    /**
     * Sanitize value
     *
     * @param string $value
     * @return string
     */
    private function sanitizeValue(string $value): string
    {
        if ( ! $this->sanitize) {
            return $value;
        }

        return filter_var($value, FILTER_SANITIZE_STRING);
    }
}