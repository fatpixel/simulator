<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SimpleZoo\Bootstrap;

/**
 * Bootstrap the application, then respond to the incoming request.
 */
$app = Bootstrap::application();
$app->respond();
