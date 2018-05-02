<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

//======================================================================================================================

// Example #5
use \Auth0\SDK\API\Authentication;
use \Auth0\SDK\Exception\ApiException;
use \GuzzleHttp\Exception\ClientException;

$auth0_api = new Authentication(getenv('AUTH0_DOMAIN'));

$config = [
    // Required for a Client Credentials grant.
    // Application must allow this grant type and be authorized for the API requested
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),

    // Also required, found in the API settings page.
    'audience' => getenv('AUTH0_MANAGEMENT_AUDIENCE'),
];

try {
    $result = $auth0_api->client_credentials($config);
    echo '<pre>' . print_r($result, true) . '</pre>';
    die();
} catch (ClientException $e) {
    echo 'Caught: ClientException - ' . $e->getMessage();
} catch (ApiException $e) {
    echo 'Caught: ApiException - ' . $e->getMessage();
}
