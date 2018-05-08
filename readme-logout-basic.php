<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

//======================================================================================================================

// Example #3
// logout.php
use Auth0\SDK\Auth0;
use Auth0\SDK\API\Authentication;

$auth0 = new Auth0([
    'domain' => getenv('AUTH0_DOMAIN'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'redirect_uri' => getenv('AUTH0_LOGIN_BASIC_CALLBACK_URL'),
]);

// Log out of the local application.
$auth0->logout();

//======================================================================================================================

// Setup the Authentication class with required credentials.
// No API calls are made on instantiation.
$auth0_api = new Authentication(getenv('AUTH0_DOMAIN'));

// Get the Auth0 logout URL to end the Auth0 session as well.
$auth0_logout = $auth0_api->get_logout_link(

    // This needs to be saved in the "Allowed Logout URLs" field in your Application settings.
    getenv('AUTH0_LOGOUT_RETURN_URL'),

    // Need to indicate the specific Application.
    getenv('AUTH0_CLIENT_ID')
);

header('Location: ' . $auth0_logout);
exit;
