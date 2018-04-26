<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader( __DIR__ . '/.env' );
$Dotenv->parse()->putenv( true );

//======================================================================================================================

// Example #1
// index.php
use Auth0\SDK\Auth0;

// Setup the Auth0 class with required credentials.
// No API calls are made on instantiation.
$auth0 = new Auth0( [

    // See Installation above to setup environment variables.
    'domain' => getenv('AUTH0_DOMAIN'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'audience' => getenv('AUTH0_AUTH_AUDIENCE'),

    // This would be the URL for this file in this example.
    'redirect_uri' => getenv('AUTH0_LOGIN_CALLBACK_URL'),

    // The minimum scope required to use the returned access token with the /userinfo endpoint.
    'scope' => 'openid',
] );

if ( ! empty( $_GET['error'] ) || ! empty( $_GET['error_description'] ) ) {
    // Handle errors sent back by Auth0.
}

// If there is a user persisted (PHP session by default), return that.
// Otherwise, look for a `state` and `code` URL parameter to validate and exchange, respectively.
// If the state validation and code exchange are successful, return the userinfo.
$userinfo = $auth0->getUser();

if ( ! empty( $userinfo ) ) {
    // We either have a persisted user or a successful code exchange.
    var_dump( $userinfo );
} else {
    // We have no persisted user and no `code` parameter so we redirect to the Universal Login Page.
    $auth0->login();
}

// Redirect somewhere to remove `code` and `state` parameters to avoid a fatal error on refresh.