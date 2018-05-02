<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

//======================================================================================================================

// Example #2
// profile.php
use Auth0\SDK\Store\SessionStore;

// Get our persistent storage interface to get the stored userinfo.
$store = new SessionStore();
$userinfo = $store->get('user');

printf(
    '<h1>Hi %s!</h1>
    <p><img width="200" src="%s"></p>
    <p><strong>Last update:</strong> %s</p>
    <p><strong>Contact:</strong> %s %s</p>',
    // Sanitize and output what we have stored.
    strip_tags($userinfo[ 'nickname' ]),
    filter_var($userinfo[ 'picture' ], FILTER_SANITIZE_URL),
    date('j/m/Y', strtotime($userinfo[ 'updated_at' ])),
    filter_var($userinfo[ 'email' ], FILTER_SANITIZE_EMAIL),
    $userinfo[ 'email_verified' ] ? '✓' : '✗'
);
