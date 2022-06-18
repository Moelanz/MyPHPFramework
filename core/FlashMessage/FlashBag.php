<?php namespace Moelanz\FlashMessage;

use Moelanz\Session\Session;

/**
 * Class FlashBag
 * @package Moelanz\FlashMessage
 *
 * @author Moelanz
 */
class FlashBag
{
    /**
     * Session Key Used To Store Messages
     *
     * @var string
     */
    const SESSION_KEY = 'flashMessages';

    /**
     * Add Message To FlashBag
     *
     * @param string $type
     * @param string $message
     */
    public function addMessage(string $type, string $message): void
    {
        $sessionEntry = $this->getSessionEntry();
        $sessionEntry[$type][] = new FlashMessage($type, $message);
        Session::set(self::SESSION_KEY, $sessionEntry);
    }

    /**
     * Has Type Stored
     *
     * @param string $type
     * @return bool
     */
    public function has(string $type): bool
    {
        return (isset($this->getSessionEntry()[$type])) && count($this->getSessionEntry()[$type]);
    }

    /**
     * Count Type Stored
     *
     * @param string $type
     * @return int
     */
    public function count(string $type): int
    {
        return static::has($type)
            ? count($this->getSessionEntry()[$type])
            : 0;
    }

    /**
     * Get Flash Messages For Type
     *
     * @param string $type
     * @return array
     */
    public function getMessages(string $type): array
    {
        if ( ! $this->has($type)) {
            return [];
        }

        $sessionEntry = $this->getSessionEntry();
        $messages =$sessionEntry[$type];
        unset($sessionEntry[$type]);
        Session::set(self::SESSION_KEY, $sessionEntry);
        return $messages;
    }

    /**
     * Get Session Entry
     *
     * @return array
     */
    public function getSessionEntry(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }
}