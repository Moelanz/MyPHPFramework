<?php namespace Moelanz\FlashMessage;

/**
 * Class FlashMessage
 * @package Moelanz\FlashMessage
 *
 * @author Moelanz
 */
class FlashMessage
{
    /**
     * Type
     *
     * @var string|null
     */
    private ? string $type = null;

    /**
     * Message
     *
     * @var string|null
     */
    private ? string $message = null;

    /**
     * FlashMessage Constructor
     *
     * @param string|null $type
     * @param string|null $message
     */
    public function __construct(string $type = null, string $message = null)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return FlashMessage
     */
    public function setMessage(?string $message): FlashMessage
    {
        $this->message = $message;
        return $this;
    }
}