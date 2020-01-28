<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Auth0\SDK\Store\SessionStore;
use Auth0\SDK\Store\CookieStore;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Auth0\SDK\Helpers\TransientStoreHandler;

// Handle errors sent back by Auth0.
if (! empty($_GET['error']) || ! empty($_GET['error_description'])) {
    printf('<h1>Error</h1><p>%s</p>', htmlspecialchars($_GET['error_description']));
    die();
}

// Nothing to do.
if (empty($_GET['code'])) {
    die('No authorization code found.');
}

// Validate callback state.
$transient_store = new CookieStore();
$state_handler = new TransientStoreHandler($transient_store);
if (! $state_handler->verify(Auth0::TRANSIENT_STATE_KEY, ( $_GET['state'] ?? null ))) {
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
    $code_exchange_result = $auth0_api->code_exchange($_GET['code'], getenv('AUTH0_REDIRECT_URI'));
} catch (Exception $e) {
    // This could be an Exception from the SDK or the HTTP client.
    die($e->getMessage());
}

$issuer = 'https://'.getenv('AUTH0_DOMAIN').'/';
$jwks_fetcher = new JWKFetcher();
$jwks = $jwks_fetcher->getKeys($issuer.'.well-known/jwks.json');
$verifier = new AsymmetricVerifier($jwks);
$idTokenVerifier = new IdTokenVerifier($issuer, getenv('AUTH0_CLIENT_ID'), $verifier);

try {
    $user_identity = $idTokenVerifier->verify($code_exchange_result['id_token']);
} catch (Exception $e) {
    die($e->getMessage());
}

$session_store = new SessionStore();
$session_store->set('user', $user_identity);
header('Location: /examples/auth-required.php');
exit;
