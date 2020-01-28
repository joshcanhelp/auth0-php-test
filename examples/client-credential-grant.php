<?php
require '../bootstrap.php';

// ======================================================================================================================
// Example #5
use \Auth0\SDK\API\Authentication;

$auth0_api = new Authentication(
    getenv('AUTH0_DOMAIN'),
    getenv('AUTH0_CLIENT_ID')
);

$config = [
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'audience' => getenv('AUTH0_MANAGEMENT_AUDIENCE'),
];

try {
    $result = $auth0_api->client_credentials($config);
    echo '<pre>'.print_r($result, true).'</pre>';
    die();
} catch (Exception $e) {
    die($e->getMessage());
}
