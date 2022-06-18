<?php namespace Moelanz\Logger;

/**
 * Class Logger
 * @package Moelanz\Logger
 *
 * @author Moelanz
 */
class Logger
{
    /**
     * Instance
     *
     * @var string|null
     */
    private ? string $instance = null;

    /**
     * Filepath
     *
     * @var string
     */
    private string $filepath = '/../../files/logs/';

    /**
     * @param string|null $instance
     * @return $this
     */
    public function setInstance(?string $instance): self
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstance(): ?string
    {
        return $this->instance;
    }

    /**
     * @param string $filepath
     * @return $this
     */
    public function setFilepath(string $filepath): self
    {
        $this->filepath = $filepath;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * Write log
     *
     * @param string $message
     * @return $this
     */
    public function log(string $message): self
    {
        file_put_contents(
            $this->getCompleteFilePath(),
            date("d-m-Y H:i: ") . $message . "\n\n",
            FILE_APPEND
        );
        return $this;
    }

    /**
     * @return string
     */
    private function getCompleteFilePath(): string
    {
        return __DIR__ . $this->getFilepath() . $this->getInstance() . '_'.date("d-m-Y").'.txt';
    }
}