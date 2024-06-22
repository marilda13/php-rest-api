<?php

namespace Model;

use \PDO as PDO;
use \PDOException;
use \Exception;

class Database
{
    protected $connection = null;
    public function __construct(private string $host,
                                private string $name,
                                private string $user,
                                private string $password)
    {
    }

    public function getConnection() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        } catch (PDOException $e) {
            throw new PDOException("Could not connect to database: " . $e->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Close cursor explicitly for good practice
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error executing select query: " . $e->getMessage());
        }
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to prepare statement: " . $query);
            }

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error executing statement: " . $e->getMessage());
        }
    }
}









