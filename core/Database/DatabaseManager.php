<?php namespace Moelanz\Database;

/**
 * Class DatabaseManager
 * @package Moelanz\Database
 *
 * @author Moelanz
 */
class DatabaseManager
{
    // Database details
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $port;

    /**
     * Connect To Database
     */
    protected function connect(): void
    {
        echo 'The class DatabaseManager can\'t connect to a database';
    }
}