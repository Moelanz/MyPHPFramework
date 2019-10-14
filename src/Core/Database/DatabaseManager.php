<?php
namespace App\Core\Database;

class DatabaseManager
{
    // Database details
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $port;

    protected function connect(): void
    {
        echo 'The class DatabaseManager can\'t connect to a database';
    }
}