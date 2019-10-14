<?php
namespace App\Core\Database;

use MongoDB\Client;

class DocumentManager extends DatabaseManager implements DatabaseInterface
{
    /**
     * @var Client $client
     */
    private $client;

    private $database;

    public function __construct()
    {
        // Set Database details from config file
        $this->host = MONGODB_HOST;
        $this->user = MONGODB_USER;
        $this->pass = MONGODB_PASS;
        $this->dbname = MONGODB_DBNAME;

        // Make a connection to the database
        $this->connect();
    }

    public function connect(): void
    {
        $dsn = 'mongodb://';
        if($this->pass !== null || $this->user !== null)
        {
            $dsn .= $this->user . ':' . $this->pass . '@';
        }
        $dsn .= $this->host . ':' . $this->port;

        $this->client = new Client($dsn);
        $this->database = $this->client->$this->dbname;
    }
}