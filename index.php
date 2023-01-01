<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if (($parts[1] != "site") && ($parts[1] != "news") && ($parts[1] != "contract")) {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

$database = new Database("localhost", "solobinapp_db", "root", "");

$sitegateway = new SiteGateway($database);
$sitecontroller = new SiteController($sitegateway);

$newsgateway = new NewsGateway($database);
$newscontroller = new NewsController($newsgateway);

$contractgateway = new ContractGateway($database);
$contractcontroller = new ContractController($contractgateway);

if ($parts[1] == "site") {
  $sitecontroller->processRequest($_SERVER["REQUEST_METHOD"], $id);
}

if ($parts[1] == "news") {
  $newscontroller->processRequest($_SERVER["REQUEST_METHOD"], $id);
}

if ($parts[1] == "contract") {
  $contractcontroller->processRequest($_SERVER["REQUEST_METHOD"], $id);
}
