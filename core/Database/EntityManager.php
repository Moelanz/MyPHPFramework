<?php namespace Moelanz\Database;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Class EntityManager
 * @package Moelanz\Database
 *
 * @author Moelanz
 */
class EntityManager extends DatabaseManager implements DatabaseInterface
{
    /**
     * @var PDO $dbh
     */
    protected $dbh;

    /**
     * @var PDOStatement $stmt
     */
    protected $stmt;

    /**
     * @var PDOException $error
     */
    protected $error;

    /**
     * EntityManager Constructor
     */
    public function __construct()
    {
        // Set Database details from config file
        $this->host = MYSQL_HOST;
        $this->user = MYSQL_USER;
        $this->pass = MYSQL_PASS;
        $this->dbname = MYSQL_DBNAME;

        // Make a connection to the database
        $this->connect();
    }

    /**
     * Connect To Database
     */
    public function connect(): void
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        // Create PDO instance
        try
        {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch(PDOException $exception)
        {
            $this->error = $exception->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepare statement with query
     *
     * @param $sql
     */
    public function query($sql): void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind values
     *
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bindParam($param, $value, $type = null)
    {
        if($type === null)
        {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;

                case $value === null:
                    $type = PDO::PARAM_NULL;
                    break;

                case $value instanceof \DateTime:
                    $type = PDO::PARAM_STR;
                    $value = $value->format('Y-m-d H:i:s');
                    break;

                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the prepared statement
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    /**
     * Get result set as array of objects
     *
     * @param $className
     * @return array|false
     */
    public function getResult($className)
    {
        $this->execute();
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        return $this->stmt->fetchAll();
    }

    /**
     * Get single result as object
     *
     * @param $className
     * @return mixed
     */
    public function getSingleResult($className)
    {
        $this->execute();
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        return $this->stmt->fetch();
    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->stmt->rowCount();
    }
}
