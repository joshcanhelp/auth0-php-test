<?php
require 'bootstrap.php';

// ======================================================================================================================
// profile.php
use Auth0\SDK\Store\SessionStore;

// Get our persistent storage interface to get the stored userinfo.
$store = new SessionStore();
$user  = $store->get('user');

if ($user) {
    // The $userinfo keys below will not exist if the user does not have that data.
    printf(
        '<h1>Hi %s!</h1>
        <p><img width="100" src="%s"></p>
        <p><strong>Last update:</strong> %s</p>
        <p><strong>Contact:</strong> %s %s</p>
        <p><a href="logout.php">Logout</a></p>',
        isset($user['nickname']) ? strip_tags($user['nickname']) : '[unknown]',
        isset($user['picture']) ? filter_var($user['picture'], FILTER_SANITIZE_URL) : 'https://gravatar.com/avatar/',
        isset($user['updated_at']) ? date('j/m/Y', strtotime($user['updated_at'])) : '[unknown]',
        isset($user['email']) ? filter_var($user['email'], FILTER_SANITIZE_EMAIL) : '[unknown]',
        ! empty($user['email_verified']) ? '✓' : '✗'
    );
} else {
    echo '<p>Please <a href="login.php">login</a> to view your profile.</p>';
}
