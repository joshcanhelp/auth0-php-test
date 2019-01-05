<?php
require 'bootstrap.php';

//======================================================================================================================

// logout.php
use Auth0\SDK\Auth0;

$auth0 = new Auth0([
    'domain' => getenv('AUTH0_DOMAIN'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'redirect_uri' => getenv('AUTH0_LOGIN_BASIC_CALLBACK_URL'),
]);

// Log out of the local application.
$auth0->logout();

//======================================================================================================================
// logout.php
use Auth0\SDK\API\Authentication;

// ... application logout

// Setup the Authentication class with required credentials.
// No API calls are made on instantiation.
$auth0_auth_api = new Authentication(getenv('AUTH0_DOMAIN'));

// Get the Auth0 logout URL to end the Auth0 session.
$auth0_logout_url = $auth0_auth_api->get_logout_link(

    // This needs to be saved in the "Allowed Logout URLs" field in your Application settings.
    getenv('AUTH0_LOGOUT_RETURN_URL'),

    // Indicate the specific Application.
    getenv('AUTH0_CLIENT_ID')
);

header('Location: ' . $auth0_logout_url);
exit;
