<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Store\SessionStore;
use Auth0\SDK\API\Helpers\State\SessionStateHandler;

// Handle errors sent back by Auth0.
if (! empty($_POST['error']) || ! empty($_POST['error_description'])) {
    printf( '<h1>Error</h1><p>%s</p>', htmlspecialchars( $_GET['error_description'] ) );
    die();
}

// Nothing to do.
if (empty( $_POST['code'] )) {
    die('No authorization code found.');
}

// Validate callback state.
$session_store = new SessionStore();
$state_handler = new SessionStateHandler($session_store);
if (! isset( $_POST['state'] ) || ! $state_handler->validate( $_POST['state'] )) {
    die('Invalid state.');
}

// Instantiate the Authentication class with the client secret.
$auth0_api = new Authentication(
    getenv('AUTH0_DOMAIN'),
    getenv('AUTH0_CLIENT_ID'),
    getenv('AUTH0_CLIENT_SECRET')
);

try {
    // Attempt to get an access_token with the code returned and original redirect URI.
    $code_exchange_result = $auth0_api->code_exchange( $_POST['code'], getenv('AUTH0_REDIRECT_URI') );
} catch (Exception $e) {
    // This could be an Exception from the SDK or the HTTP client.
    die( $e->getMessage() );
}

try {
    // Attempt to get an access_token with the code returned and original redirect URI.
    $userinfo_result = $auth0_api->userinfo( $code_exchange_result['access_token'] );
} catch (Exception $e) {
    die( $e->getMessage() );
}

$session_store->set('user', $userinfo_result);
header('Location: /examples/auth-required.php');
exit;
