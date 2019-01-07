<?php
require '../bootstrap.php';

// ======================================================================================================================
// decode-jwt.php
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Exception\CoreException;

if (empty($_GET['id_token'])) {
    die( 'No `id_token` URL parameter' );
}

if (empty($_GET['token_alg']) || ! in_array($_GET['token_alg'], [ 'HS256', 'RS256' ])) {
    die( 'Missing or invalid `token_alg` URL parameter' );
}

$idToken  = rawurldecode($_GET['id_token']);
$tokenAlg = rawurldecode($_GET['token_alg']);

$config = [
    // Array of allowed algorithms; never pass more than what is expected.
    'supported_algs' => [ $tokenAlg ],
    // Array of allowed "aud" values.
    'valid_audiences' => [ getenv('AUTH0_CLIENT_ID') ],
];

if ('HS256' === $tokenAlg) {
    // HS256 tokens require the Client Secret to decode.
    $config['client_secret']         = getenv('AUTH0_CLIENT_SECRET');
    $config['secret_base64_encoded'] = false;
} else {
    // RS256 tokens require a valid issuer.
    $config['authorized_iss'] = [ 'https://'.getenv('AUTH0_DOMAIN').'/' ];
}

try {
    $verifier      = new JWTVerifier($config);
    $decoded_token = $verifier->verifyAndDecode($idToken);
    echo '<pre>'.print_r($decoded_token, true).'</pre>';
} catch (InvalidTokenException $e) {
    echo 'Caught: InvalidTokenException - '.$e->getMessage();
} catch (CoreException $e) {
    echo 'Caught: CoreException - '.$e->getMessage();
} catch (\Exception $e) {
    echo 'Caught: Exception - '.$e->getMessage();
}
