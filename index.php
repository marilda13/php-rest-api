<?php
declare(strict_types=1);

use Controller\Api\ProductController;
use Model\Database;
use Model\ProductGateway;

require 'autoload.php';
require __DIR__ . "/inc/bootstrap.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[2] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[3] ?? null;

$database = new Database(DB_HOST, DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);

$gateway = new ProductGateway($database);
$controller = new ProductController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);













