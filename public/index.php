<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Container;
use App\Core\Router;
use App\Presentation\Web\Responder\ResponderInterface;

// --- Security: Bootstrapping Environment ---
$container = new Container();
$env = $_ENV['APP_ENV'] ?? 'prod';
$logDir = dirname(__DIR__) . '/logs';

// Ensure log directory exists
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// --- Security: Core Router/Responder ---
$router = $container->get(Router::class);
$responder = $container->get(ResponderInterface::class);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$request = array_merge($_GET, $_POST);

try {
    $result = $router->dispatch($method, (string)$uri);
    
    if ($result !== null) {
        $actionClass = $result['action'];
        $params = (array)($result['params'] ?? []);
        
        // Merge route parameters into the request array
        $request = array_merge($request, $params);
        
        $action = $container->get($actionClass);
        $action($request);
    } else {
        // 404
        $responder->error(404, "The requested page '{$uri}' could not be found.");
    }
} catch (Exception $e) {
    // --- Security: Professional Logging & Error Suppression ---
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$env}] Error: " . $e->getMessage() . "\nStack-trace: " . $e->getTraceAsString() . "\n\n";
    file_put_contents($logDir . '/app.log', $logMessage, FILE_APPEND);

    $displayMessage = "A catastrophic error occurred.";
    if ($env === 'dev') {
        $displayMessage .= " Details: " . $e->getMessage();
    } else {
        $displayMessage .= " Our team has been notified.";
    }
    
    $responder->error(500, $displayMessage);
}
