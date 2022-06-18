<?php namespace Moelanz\Controller\Variables;

use Moelanz\FlashMessage\FlashBag;
use Moelanz\Http\Request;

/**
 * Class DefaultVariables
 * @package Moelanz\Controller\Variables
 *
 * @author Moelanz
 */
class DefaultVariables
{
    /**
     * Request
     *
     * @var Request|null
     */
    private ? Request $request = null;

    /**
     * FlashBag
     *
     * @var FlashBag|null
     */
    private ? FlashBag $flashBag = null;

    /**
     * DefaultVariables Constructor
     *
     * @param Request $request
     * @param FlashBag $flashBag
     */
    public function __construct(Request $request, FlashBag $flashBag)
    {
        $this->request = $request;
        $this->flashBag = $flashBag;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return FlashBag|null
     */
    public function getFlashBag(): ?FlashBag
    {
        return $this->flashBag;
    }


}