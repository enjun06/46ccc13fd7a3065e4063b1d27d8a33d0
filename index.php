<?php
require '../send-mail/vendor/autoload.php';
require '../send-mail/app/Database.php';

use App\Database;

$database = new Database();

$router = require '../send-mail/app/routes/api.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

$method = $_SERVER['REQUEST_METHOD'];

if (preg_match('/\/api\/mail\/(\d+)/', $uri, $matches)) {
    $id = $matches[1];
    if ($method == 'GET') {
        $router->dispatch('/api/mail/{id}', $method, $id);
    } elseif ($method == 'DELETE') {
        $router->dispatch('/api/mail/{id}', $method, $id);
    } else {
        header("HTTP/1.1 405 Method Not Allowed");
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    }
} else {
    $router->dispatch($uri, $method);
}
