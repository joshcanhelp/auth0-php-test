<?php
require 'bootstrap.php';

// ======================================================================================================================
// Example #1
// login.php
use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\ApiException;

// Handle errors sent back by Auth0.
if (! empty($_GET['error']) || ! empty($_GET['error_description'])) {
    printf( '<h1>Error</h1><p>%s</p>', htmlspecialchars( $_GET['error_description'] ) );
    die();
}

// Initialize the Auth0 class with required credentials.
$auth0 = new Auth0([
    'domain' => getenv('AUTH0_DOMAIN'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'redirect_uri' => getenv('AUTH0_REDIRECT_URI'),

    // The scope determines what data is provided by the /userinfo endpoint.
    // There must be at least one valid scope included here.
    'scope' => 'openid',
]);

// If there is a user persisted (PHP session by default), return that.
// Otherwise, look for a "state" and "code" URL parameter to validate and exchange.
// If the state validation and code exchange are successful, return the userinfo.
try {
    $userinfo = $auth0->getUser();
} catch (CoreException $e) {
    // Invalid state or session already exists.
    die( $e->getMessage() );
} catch (ApiException $e) {
    // Access token not present.
    die( $e->getMessage() );
}

// No user information so redirect to the Universal Login Page.
if (empty($userinfo)) {
    $auth0->login();
}

// We either have a persisted user or a successful code exchange.
var_dump($userinfo);

// This is where a user record in a local database could be retrieved or created.
// End with a redirect to a new page.
header('Location: /profile.php');
