<?php
require '../bootstrap.php';

// ======================================================================================================================
// decode-jwt.php
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\SymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;

if (empty($_GET['id_token'])) {
    die('No `id_token` URL parameter');
}

if (empty($_GET['token_alg']) || ! in_array($_GET['token_alg'], [ 'HS256', 'RS256' ])) {
    die('Missing or invalid `token_alg` URL parameter');
}

$id_token  = rawurldecode($_GET['id_token']);

$token_issuer  = 'https://'.getenv('AUTH0_DOMAIN').'/';
$signature_verifier = null;

if ('RS256' === $_GET['token_alg']) {
    $jwks_fetcher = new JWKFetcher();
    $jwks        = $jwks_fetcher->getKeys($token_issuer.'.well-known/jwks.json');
    $signature_verifier = new AsymmetricVerifier($jwks);
} elseif ('HS256' === $_GET['token_alg']) {
    $signature_verifier = new SymmetricVerifier(getenv('AUTH0_CLIENT_SECRET'));
}

$token_verifier = new IdTokenVerifier(
    $token_issuer,
    getenv('AUTH0_CLIENT_ID'),
    $signature_verifier
);

try {
    $decoded_token = $token_verifier->verify($id_token);
    echo '<pre>'.print_r($decoded_token, true).'</pre>';
} catch (\Exception $e) {
    echo 'Caught: Exception - '.$e->getMessage();
}
