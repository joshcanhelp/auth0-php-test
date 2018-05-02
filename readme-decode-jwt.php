<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

//======================================================================================================================

// Example #4
// decode-jwt.php
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Exception\CoreException;

// Do we have an ID token?
if (empty($_GET[ 'id_token' ])) {
    echo '<code>No `id_token` URL parameter!</code> ';
    exit;
}

// Do we have a valid algorithm?
if (empty($_GET[ 'token_alg' ]) || ! in_array($_GET[ 'token_alg' ], [ 'HS256', 'RS256' ])) {
    echo '<code>Missing or invalid `token_alg` URL parameter!</code> ';
    exit;
}

if ('HS256' === $_GET[ 'token_alg' ]) {
    $config = [
        'supported_algs' => [ 'HS256' ],
        'client_secret' => getenv('AUTH0_CLIENT_SECRET'),
        'valid_audiences' => [ getenv('AUTH0_CLIENT_ID') ]
    ];
} else {
    $config = [
        'supported_algs' => [ 'RS256' ],
        'authorized_iss' => [ 'https://' . getenv('AUTH0_DOMAIN') . '/' ],
        'valid_audiences' => [ getenv('AUTH0_CLIENT_ID') ]
    ];
}

$decoded_token = [];
try {
    $verifier = new JWTVerifier($config);
    $decoded_token = $verifier->verifyAndDecode($_GET[ 'id_token' ]);
} catch (InvalidTokenException $e) {
    echo 'Caught: InvalidTokenException - ' . $e->getMessage();
} catch (CoreException $e) {
    echo 'Caught: CoreException - ' . $e->getMessage();
} catch (\Exception $e) {
    echo 'Caught: Exception - ' . $e->getMessage();
}

echo '<pre>' . print_r($decoded_token, true) . '</pre>';
die();
