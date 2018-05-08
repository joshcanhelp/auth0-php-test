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

if ($userinfo) {
    // The $userinfo keys below will not exist if the user does not have that data.
    printf(
        '<h1>Hi %s!</h1>
        <p><img width="100" src="%s"></p>
        <p><strong>Last update:</strong> %s</p>
        <p><strong>Contact:</strong> %s %s</p>',
        isset($userinfo['nickname']) ? strip_tags($userinfo['nickname']) : '[unknown]',
        isset($userinfo['picture'])
            ? filter_var($userinfo['picture'], FILTER_SANITIZE_URL)
            : 'https://www.gravatar.com/avatar/?d=retro',
        isset($userinfo['updated_at']) ? date('j/m/Y', strtotime($userinfo['updated_at'])) : '[unknown]',
        isset($userinfo['email'])
            ? filter_var($userinfo['email'], FILTER_SANITIZE_EMAIL)
            : '[unknown]',
        !empty($userinfo[ 'email_verified' ]) ? '✓' : '✗'
    );
} else {
    echo '<p>Please login to view your profile.</p>';
}
