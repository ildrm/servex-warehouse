<?php

namespace Servex\Controllers;

use Servex\Service\ETLService;
use Servex\Http\Request;
use Servex\Http\Response;

class ETLController
{
    private $etlService;

    public function __construct(ETLService $etlService)
    {
        $this->etlService = $etlService;
    }

    public function extractData(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
        $source = $params['source'] ?? null;
        $query = $params['query'] ?? null;
        $databaseName = $params['database'] ?? null;
        $collectionName = $params['collection'] ?? null;

        if (!$source || !$query) {
            return $response->withJson(['error' => 'Missing required parameters: source and query'], 400);
        }

        try {
            $data = $this->etlService->extractData($source, $query, $databaseName, $collectionName);
            return $response->withJson(['data' => $data]);
        } catch (\InvalidArgumentException $e) {
            return $response->withJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $response->withJson(['error' => 'An error occurred during data extraction: ' . $e->getMessage()], 500);
        }
    }

    public function transformData(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (empty($data)) {
            return $response->withJson(['error' => 'No data provided in the request body'], 400);
        }

        try {
            $transformedData = $this->etlService->transformData($data);
            return $response->withJson(['data' => $transformedData]);
        } catch (\Exception $e) {
            return $response->withJson(['error' => 'An error occurred during data transformation: ' . $e->getMessage()], 500);
        }
    }

    public function loadData(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $target = $request->getQueryParams()['target'] ?? null;

        if (empty($data) || !$target) {
            return $response->withJson(['error' => 'Missing required parameters: data or target'], 400);
        }

        try {
            $this->etlService->loadData($data, $target);
            return $response->withJson(['message' => 'Data loaded successfully']);
        } catch (\Exception $e) {
            return $response->withJson(['error' => 'An error occurred during data loading: ' . $e->getMessage()], 500);
        }
    }
}
