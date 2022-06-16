<?php namespace Moelanz\Database;

/**
 * Interface DatabaseInterface
 * @package Moelanz\Database
 *
 * @author Moelanz
 */
interface DatabaseInterface
{
    /**
     * Connect To Database
     */
    public function connect(): void;
}
