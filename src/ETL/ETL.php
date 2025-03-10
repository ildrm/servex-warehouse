<?php

namespace ETL;

use PDO;
use MongoDB\Client as MongoDBClient;

class ETL
{
    private $mysqlConnection;
    private $postgresqlConnection;
    private $mongodbConnection;

    public function __construct($config)
    {
        $this->mysqlConnection = $this->connectMySQL($config['mysql']);
        $this->postgresqlConnection = $this->connectPostgreSQL($config['postgresql']);
        $this->mongodbConnection = $this->connectMongoDB($config['mongodb']);
    }

    private function connectMySQL($config)
    {
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
            return new PDO($dsn, $config['username'], $config['password']);
        } catch (\PDOException $e) {
            die("MySQL Connection failed: " . $e->getMessage());
        }
    }

    private function connectPostgreSQL($config)
    {
        try {
            $dsn = "pgsql:host={$config['host']};dbname={$config['database']}";
            return new PDO($dsn, $config['username'], $config['password']);
        } catch (\PDOException $e) {
            die("PostgreSQL Connection failed: " . $e->getMessage());
        }
    }

    private function connectMongoDB($config)
    {
        try {
            return new MongoDBClient("mongodb://{$config['username']}:{$config['password']}@{$config['host']}/{$config['database']}");
        } catch (\Exception $e) {
            die("MongoDB Connection failed: " . $e->getMessage());
        }
    }

    public function extractDataFromMySQL($query)
    {
        $stmt = $this->mysqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function extractDataFromPostgreSQL($query)
    {
        $stmt = $this->postgresqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function extractDataFromMongoDB($databaseName, $collectionName)
    {
        $database = $this->mongodbConnection->selectDatabase($databaseName);
        $collection = $database->selectCollection($collectionName);
        return iterator_to_array($collection->find());
    }

    public function transformData($data)
    {
        // Standardize date formats
        foreach ($data as &$item) {
            if (isset($item['date'])) {
                $item['date'] = date('Y-m-d', strtotime($item['date']));
            }
        }

        // Clean data (e.g., trim strings, remove empty values)
        foreach ($data as &$item) {
            foreach ($item as $key => &$value) {
                if (is_string($value)) {
                    $value = trim($value);
                }
                if (empty($value)) {
                    unset($item[$key]);
                }
            }
        }

        return $data;
    }

    public function loadDataToTarget($data, $targetConnection)
    {
        // Implement logic to load data into the target database
        // For example, inserting data into a MySQL table
        if ($targetConnection instanceof PDO) {
            $columns = array_keys($data[0]);
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $sql = "INSERT INTO target_table (" . implode(', ', $columns) . ") VALUES ($placeholders)";
            $stmt = $targetConnection->prepare($sql);

            foreach ($data as $row) {
                $stmt->execute(array_values($row));
            }
        }
    }
}
