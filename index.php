<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Composer autoloader for Auth0.
require __DIR__.'/auth0/vendor/autoload.php';

// Composer autoloader for project.
require __DIR__.'/vendor/autoload.php';

// Functions we should have.
require __DIR__.'/functions.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Scaffold\Controllers;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Cache\Adapter\Filesystem\FilesystemCachePool;

use josegonzalez\Dotenv\Loader;

$Dotenv = new Loader(__DIR__.'/.env');
$Dotenv->parse()->putenv(true);

define('DOC_ROOT', __DIR__.'/');
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST']);
define('AUTH0_TENANT', getenv('AUTH0_TENANT'));
define('AUTH0_DOMAIN', AUTH0_TENANT.'.auth0.com');
define('AUTH0_CLIENT_ID', getenv('AUTH0_CLIENT_ID'));
define('AUTH0_CLIENT_SECRET', getenv('AUTH0_CLIENT_SECRET'));
define('AUTH0_CALLBACK_PATH', '/auth/callback');

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem        = new Filesystem($filesystemAdapter);

$pool = new FilesystemCachePool($filesystem);

$auth0 = new Auth0([
    'domain'                      => AUTH0_DOMAIN,
    'client_id'                   => AUTH0_CLIENT_ID,
    'client_secret'               => AUTH0_CLIENT_SECRET,
    'redirect_uri'                => BASE_URL . AUTH0_CALLBACK_PATH,
    'legacy_samesite_none_cookie' => true,
    'cache_handler'               => $pool,
]);

// Routes.
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', Controllers\RootController::class);

        // Login/out routes
        $r->addRoute('GET', '/login', Controllers\LoginController::class);
        $r->addRoute('GET', '/logout', Controllers\LogoutController::class);

        // Callbacks
        $r->addRoute(['GET', 'POST'], AUTH0_CALLBACK_PATH, Controllers\CallbackController::class);
        $r->addRoute('GET', '/callback-show-code', Controllers\CallbackShowCodeController::class);
        $r->addRoute('GET', '/callback-show-data', Controllers\CallbackShowDataController::class);
        $r->addRoute('GET', '/callback-idp-sso', Controllers\CallbackIdpSsoController::class);

        // User
        $r->addRoute('GET', '/profile', Controllers\ProfileController::class);

        // M-API testing
        $r->addRoute('GET', '/logs', Controllers\GetLogsController::class);
        $r->addRoute('GET', '/users', Controllers\GetUsersController::class);
        $r->addRoute('GET', '/grants', Controllers\GetGrantsController::class);
        $r->addRoute('GET', '/roles-test', Controllers\RolesTestController::class);
        $r->addRoute('GET', '/users-test', Controllers\UsersTestController::class);
        $r->addRoute('GET', '/import-users', Controllers\ImportUsersGetTestController::class);
        $r->addRoute('POST', '/import-users', Controllers\ImportUsersPostTestController::class);
    }
);

// Strip query string (?foo=bar) and decode URI.
$uri = explode('?', $_SERVER['REQUEST_URI'])[0];

$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], rawurldecode($uri));

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '<pre>'.print_r($routeInfo, true).'</pre>';
        header('HTTP/1.0 405 Method Not Allowed');
        die('<h1>405</h1>');

    case FastRoute\Dispatcher::FOUND:
        Predis\Autoloader::register();
        $client = new Predis\Client();
        $auth_api = new Authentication(AUTH0_DOMAIN, AUTH0_CLIENT_ID, AUTH0_CLIENT_SECRET);
        $handler = new $routeInfo[1]($auth0, $auth_api, $client, $routeInfo[2]);
        $handler->handle();
        break;

    default:
        echo '<pre>'.print_r($routeInfo, true).'</pre>';
        header('HTTP/1.0 404 Not Found');
        die('<h1>404</h1>');
}
