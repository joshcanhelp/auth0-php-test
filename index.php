<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Composer autoloader
require __DIR__ . '/auth0/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

// Use statements
use Auth0\SDK\Auth0;
use Auth0\SDK\API\Management;
use Auth0\SDK\Scaffold\Controllers;
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

// Constants
define('DOC_ROOT', __DIR__ . '/');
define('BASE_URL', 'http://' . $_SERVER[ 'HTTP_HOST' ]);

define('AUTH0_DOMAIN', getenv('AUTH0_DOMAIN'));
define('AUTH0_CLIENT_ID', getenv('AUTH0_CLIENT_ID'));
define('AUTH0_CLIENT_SECRET', getenv('AUTH0_CLIENT_SECRET'));
define('AUTH0_CALLBACK_PATH', '/auth/callback');

// Startup Auth0
$auth0 = new Auth0([
    'domain' => AUTH0_DOMAIN,
    'client_id' => AUTH0_CLIENT_ID,
    'client_secret' => AUTH0_CLIENT_SECRET,
    'redirect_uri' => BASE_URL . AUTH0_CALLBACK_PATH,
    'scope' => 'openid email name nickname offline_access',
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
]);

$mgmt_api = new Management(getenv('AUTH0_MANAGEMENT_API_TOKEN'), AUTH0_DOMAIN);

// Routes
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', Controllers\RootController::class );

    $r->addRoute('GET', '/login', Controllers\LoginController::class );
    $r->addRoute('GET', '/logout', Controllers\LogoutController::class );
    $r->addRoute('GET', AUTH0_CALLBACK_PATH, Controllers\AuthCallbackController::class );
    $r->addRoute('GET', '/profile', Controllers\ProfileController::class );

    $r->addRoute('GET', '/logs', Controllers\GetLogsController::class );
    $r->addRoute('GET', '/users', Controllers\GetUsersController::class );
});

// Strip query string (?foo=bar) and decode URI
$uri = $_SERVER['REQUEST_URI'];
$pos = strpos($uri, '?');
if (false !== $pos) {
    $uri = substr($uri, 0, $pos);
}

$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], rawurldecode($uri));

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '<pre>' . print_r( $routeInfo, TRUE ) . '</pre>';
        header("HTTP/1.0 404 Not Found");
        die('<h1>404</h1>');

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '<pre>' . print_r( $routeInfo, TRUE ) . '</pre>';
        header("HTTP/1.0 405 Method Not Allowed");
        die('<h1>405</h1>');

    case FastRoute\Dispatcher::FOUND:
        $handler = new $routeInfo[1]($auth0, $mgmt_api, $routeInfo[2]);
        $handler->handle();
}
