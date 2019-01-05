<?php
require '../bootstrap.php';

//======================================================================================================================

use Auth0\SDK\API\Authentication;
use Auth0\SDK\Store\SessionStore;
use Auth0\SDK\API\Helpers\State\SessionStateHandler;

if ( ! is_user_authenticated() ) {

    // Generate and store a state value.
    $session_store = new SessionStore();
    $state_handler = new SessionStateHandler($session_store);
    $state_value = $state_handler->issue();

    $auth0_api = new Authentication(
        getenv('AUTH0_DOMAIN'),
        getenv('AUTH0_CLIENT_ID')
    );

    // Generate the authorize URL.
    $authorize_url = $auth0_api->get_authorize_link(
        'code', // Response expected by the application.
        getenv('AUTH0_REDIRECT_URI'), // Callback URL to respond to.
        null, // Connection to use, null for all.
        $state_value, // State value to send with the request.
        [
            'response_mode' => 'query', // Respond with the code and state in the URL query.
            'scope' => 'openid email profile', // Userinfo to allow.
        ]
    );

    header('Location: ' . $authorize_url);
    exit;
}

echo '<h1>Sensitive data!</h1>';

function is_user_authenticated() {
    $store = new SessionStore();
    $userinfo = $store->get('user');
    return !empty( $userinfo );
}
