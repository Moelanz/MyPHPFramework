<?php
namespace App\Service;

use App\Controller\ExceptionController;

class ExceptionService
{
    /**
     * @var ExceptionController
     */
    private $exceptionController;

    public function __construct(ExceptionController $exceptionController)
    {
        $this->exceptionController = $exceptionController;
    }

    public function setExceptionController(ExceptionController $exceptionController): void
    {
        $this->exceptionController = $exceptionController;
    }

    public function getExceptionController(): ExceptionController
    {
        return $this->exceptionController;
    }
}