<?php

namespace Servex\Service;

use Servex\Storage\StorageInterface;
use Servex\Service\ServiceInterface;

class ETLService implements ServiceInterface
{
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function extractData($source, $query, $databaseName = null, $collectionName = null)
    {
        switch ($source) {
            case 'mysql':
                return $this->storage->query($query);
            case 'postgresql':
                return $this->storage->query($query);
            case 'mongodb':
                return $this->storage->find($databaseName, $collectionName, $query);
            default:
                throw new \InvalidArgumentException("Invalid source: $source");
        }
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

    public function loadData($data, $target)
    {
        $this->storage->insert($target, $data);
    }
}
