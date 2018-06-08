<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Composer autoloader
require __DIR__ . '/auth0/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Auth0\SDK\API\Management;
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

$a0_domain        = getenv('AUTH0_DOMAIN');
$a0_client_id     = getenv('AUTH0_CLIENT_ID');
$a0_client_secret = getenv('AUTH0_CLIENT_SECRET');
$a0_redirect_uri  = getenv('AUTH0_CALLBACK_URL');
$a0_audience      = getenv('AUTH0_AUTH_AUDIENCE');

// Startup Auth0
$auth0 = new Auth0([
    'domain' => $a0_domain,
    'client_id' => $a0_client_id,
    'client_secret' => $a0_client_secret,
    'redirect_uri' => $a0_redirect_uri,
    'audience' => $a0_audience,
    'scope' => 'openid email name nickname offline_access',
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
]);

$mgmt_api = new Management(getenv('AUTH0_MANAGEMENT_API_TOKEN'), $a0_domain);

// Dynamic page actions
if (isset($_GET[ 'action' ])) {
    switch ($_GET[ 'action' ]) {
        case 'login':
            $auth0->login();
            break;
        case 'logout':
            $auth0->logout();
            break;
        case 'renew':
            try {
                $auth0->renewTokens();
                header('Location: ' . $a0_redirect_uri);
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
            }
            break;
    }
}
