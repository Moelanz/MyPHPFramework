<?php namespace Moelanz\Session;

/**
 * Class Session
 * @package Moelanz\Session
 *
 * @author Moelanz
 */
class Session
{
    /**
     * Start Session
     */
    public static function start(): void
    {
        session_start();
    }

    /**
     * Destroy Session
     */
    public static function destroy(): void
    {
        session_destroy();
    }

    /**
     * Get From Session
     *
     * @param string $variable
     * @param null $default
     * @return mixed|null
     */
    public static function get(string $variable, $default = null)
    {
        return static::has($variable) ? $_SESSION[$variable] : $default;
    }

    /**
     * Set To Session
     *
     * @param string $variable
     * @param $value
     */
    public static function set(string $variable, $value): void
    {
        $_SESSION[$variable] = $value;
    }

    /**
     * Session Has Variable
     *
     * @param string $variable
     * @return bool
     */
    public static function has(string $variable): bool
    {
        return isset($_SESSION[$variable]);
    }

    /**
     * Remove From Session
     *
     * @param string $variable
     */
    public static function remove(string $variable): void
    {
        if ( ! static::has($variable)) {
            return;
        }
        unset($_SESSION[$variable]);
    }
}