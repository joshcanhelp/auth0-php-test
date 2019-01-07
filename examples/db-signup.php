<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;

$auth0_api = new Authentication(
    getenv('AUTH0_DOMAIN'),
    getenv('AUTH0_CLIENT_ID')
);

try {
    $result = $auth0_api->dbconnections_signup(
        // A valid email address that does not already exist for the connection.
        'user@example.com',
        // Password conforming to the password policy for the connection.
        'That_Is_1_Strong_Password!',
        // Database connection name.
        'Username-Password-Authentication'
    );
} catch (Exception $e) {
    // This could be an Exception from the SDK or the HTTP client.
    die( $e->getMessage() );
}

// This will include the user ID and email address.
var_dump( $result );
