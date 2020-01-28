<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Store\SessionStore;
use Auth0\SDK\API\Helpers\State\SessionStateHandler;
use Auth0\SDK\JWTVerifier;

// Nothing to do.
if (empty($_POST['id_token'])) {
    die('No ID token found.');
}

// Validate callback state.
$session_store = new SessionStore();
$state_handler = new SessionStateHandler($session_store);
if (! isset($_POST['state']) || ! $state_handler->validate($_POST['state'])) {
    die('Invalid state.');
}

// Instantiate the Authentication class.
$auth0_api = new Authentication(
    getenv('AUTH0_DOMAIN'),
    getenv('AUTH0_CLIENT_ID')
);

try {
    $jwtVerifier = new JWTVerifier(
        [
        'valid_audiences' => [ getenv('AUTH0_CLIENT_ID') ],
        'supported_algs'  => [ 'RS256' ],
        'authorized_iss'  => [ 'https://'.getenv('AUTH0_DOMAIN').'/' ],
        ]
    );
    $userinfo    = $jwtVerifier->verifyAndDecode($_POST['id_token']);
} catch (Exception $e) {
    die($e->getMessage());
}

if ($userinfo->nonce !== $session_store->get('auth0_webauth_nonce')) {
    die('Invalid nonce.');
}

$session_store->set('user', $userinfo);

header('Location: /examples/auth-required.php');
exit;
