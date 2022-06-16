<?php namespace Moelanz\Exception;

use Moelanz\Controller\ExceptionController;

/**
 * Class ExceptionService
 * @package Moelanz\Exception
 */
class ExceptionService
{
    /**
     * @var ExceptionController
     */
    private $exceptionController;

    /**
     * @param ExceptionController $exceptionController
     */
    public function __construct(ExceptionController $exceptionController)
    {
        $this->exceptionController = $exceptionController;
    }

    /**
     * @param ExceptionController $exceptionController
     */
    public function setExceptionController(ExceptionController $exceptionController): void
    {
        $this->exceptionController = $exceptionController;
    }

    /**
     * @return ExceptionController
     */
    public function getExceptionController(): ExceptionController
    {
        return $this->exceptionController;
    }
}
