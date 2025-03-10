<?php

use Servex\Controllers\ETLController;
use Servex\Core\Application;
use Servex\Core\Router;
use Servex\Service\ETLService;
use Servex\Storage\Storage;

require __DIR__ . '/../vendor/autoload.php';

// Define the path to the configuration file
$configPath = __DIR__ . '/config/config.php';

// Load configuration
$config = require $configPath;

// Initialize storage and ETL service
$storage = new Storage($config);
$etlService = new ETLService($storage);

// Initialize ETL controller
$etlController = new ETLController($etlService);

// Define routes
$router = new Router();

$router->get('/extract', [$etlController, 'extractData']);
$router->post('/transform', [$etlController, 'transformData']);
$router->post('/load', [$etlController, 'loadData']);

// Run the application
$app = new Application($configPath);
$app->run();
