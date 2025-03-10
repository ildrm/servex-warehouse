<?php

namespace Servex\Service;

interface ServiceInterface
{
    public function extractData($source, $query, $databaseName = null, $collectionName = null);
    public function transformData($data);
    public function loadData($data, $target);
}
