<?php

namespace Servex\Storage;

interface StorageInterface
{
    public function query($query);
    public function find($databaseName, $collectionName, $query);
    public function insert($target, $data);
}
