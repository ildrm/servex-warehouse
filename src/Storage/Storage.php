<?php

namespace Servex\Storage;

use PDO;
use MongoDB\Client as MongoDBClient;

class Storage implements StorageInterface
{
    private $mysqlConnection;
    private $postgresqlConnection;
    private $mongodbConnection;

    public function __construct($config)
    {
        if (@$config['mysql']) $this->mysqlConnection = $this->connectMySQL($config['mysql']);
        if (@$config['postgresql']) $this->postgresqlConnection = $this->connectPostgreSQL($config['postgresql']);
        if (@$config['mongodb']) $this->mongodbConnection = $this->connectMongoDB($config['mongodb']);
    }

    private function connectMySQL($config)
    {
        try {
            $dsn = "mysql:host=".$config['host'].";dbname=".$config['database']."";
            return new PDO($dsn, $config['username'], $config['password']);
        } catch (\PDOException $e) {
            throw new \RuntimeException("MySQL Connection failed: " . $e->getMessage());
        }
    }

    private function connectPostgreSQL($config)
    {
        try {
            $dsn = "pgsql:host={$config['host']};dbname={$config['database']}";
            return new PDO($dsn, $config['username'], $config['password']);
        } catch (\PDOException $e) {
            throw new \RuntimeException("PostgreSQL Connection failed: " . $e->getMessage());
        }
    }

    private function connectMongoDB($config)
    {
        try {
            return new MongoDBClient("mongodb://{$config['username']}:{$config['password']}@{$config['host']}/{$config['database']}");
        } catch (\Exception $e) {
            throw new \RuntimeException("MongoDB Connection failed: " . $e->getMessage());
        }
    }

    public function query($query)
    {
        $stmt = $this->mysqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($databaseName, $collectionName, $query)
    {
        $database = $this->mongodbConnection->selectDatabase($databaseName);
        $collection = $database->selectCollection($collectionName);
        return iterator_to_array($collection->find($query));
    }

    public function insert($target, $data)
    {
        if ($target instanceof PDO) {
            $columns = array_keys($data[0]);
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $sql = "INSERT INTO target_table (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            $stmt = $target->prepare($sql);

            foreach ($data as $row) {
                $stmt->execute(array_values($row));
            }
        }
    }
}
