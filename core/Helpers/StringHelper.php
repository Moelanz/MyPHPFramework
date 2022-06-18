<?php namespace Moelanz\Helpers;

/**
 * Class StringHelper
 * @package Moelanz\Helpers
 *
 * @author Moelanz
 */
class StringHelper
{
    /**
     * Convert To Snake Case
     *
     * @param string $input
     * @return string
     */
    public static function convertToSnakeCase(string $input): string
    {
        return  strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}