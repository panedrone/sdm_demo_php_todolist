<?php

require_once 'Route.php';
require_once 'handlers.php';

use Steampixel\Route;

Route::add('/api/groups', function () {
    handle_groups();
}, ['get', 'post']);

Route::add('/api/groups/([0-9]*)', function ($g_id) {
    handle_group($g_id);
}, ['get', 'put', 'delete']);

Route::add('/api/groups/([0-9]*)/tasks', function ($g_id) {
    handle_group_tasks($g_id);
}, ['get', 'post']);

Route::add('/api/task/([0-9]*)', function ($t_id) {
    handle_task($t_id);
}, ['get', 'put', 'delete']);

Route::methodNotAllowed(function ($path, $method) {
    header("HTTP/1.1 405 Not Allowed $path $method");
    http_response_code(Response::HTTP_METHOD_NOT_ALLOWED);
});

Route::pathNotFound(function ($path) {
    header("HTTP/1.1 404 Not Found $path");
    http_response_code(Response::HTTP_NOT_FOUND);
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_parts = explode('/api/', $uri);
if (count($uri_parts) > 1) {
    $base = $uri_parts[0];
} else {
    $base = "/";
}

Route::run($base);
