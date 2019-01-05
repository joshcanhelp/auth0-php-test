<?php
require '../bootstrap.php';

//======================================================================================================================

// Example #5
use \Auth0\SDK\API\Authentication;
use \Auth0\SDK\Exception\ApiException;
use \GuzzleHttp\Exception\ClientException;

$auth0_api = new Authentication( getenv('AUTH0_DOMAIN') );

$config = [
    'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
    'client_id' => getenv('AUTH0_CLIENT_ID'),
    'audience' => getenv('AUTH0_MANAGEMENT_AUDIENCE'),
];

try {
    $result = $auth0_api->client_credentials($config);
    echo '<pre>' . print_r($result, true) . '</pre>';
    die();
} catch (ClientException $e) {
    die( $e->getMessage() );
} catch (ApiException $e) {
    die( $e->getMessage() );
}
