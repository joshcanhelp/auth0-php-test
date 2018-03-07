<?php

// Composer autoloader
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/auth0/vendor/autoload.php';

use Auth0\SDK\Auth0;
use Dotenv\Dotenv;

// Setup environment vars
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$a0_domain        = getenv('AUTH0_DOMAIN');
$a0_client_id     = getenv('AUTH0_CLIENT_ID');
$a0_client_secret = getenv('AUTH0_CLIENT_SECRET');
$a0_redirect_uri  = getenv('AUTH0_CALLBACK_URL');
$a0_audience      = getenv('AUTH0_AUDIENCE');
$a0_token         = getenv('AUTH0_TOKEN');

// Startup Auth0
$auth0 = new Auth0( [
    'domain' => $a0_domain,
    'client_id' => $a0_client_id,
    'client_secret' => $a0_client_secret,
    'redirect_uri' => $a0_redirect_uri,
    'audience' => $a0_audience,
    'scope' => 'openid profile',
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
] );

// Dynamic page actions
$action = ! empty( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : '';
switch ( $action ) {
    case 'login':
        $auth0->login();
        break;
    case 'logout':
        $auth0->logout();
        break;
}