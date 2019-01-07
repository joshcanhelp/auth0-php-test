<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Store\SessionStore;
use Auth0\SDK\API\Helpers\State\SessionStateHandler;

if (! isUserAuthenticated()) {
    // Generate and store a state value.
    $session_store = new SessionStore();
    $state_handler = new SessionStateHandler($session_store);
    $state_value   = $state_handler->issue();

    $auth0_api = new Authentication(
        getenv('AUTH0_DOMAIN'),
        getenv('AUTH0_CLIENT_ID')
    );

    // Generate the authorize URL.
    $authorize_url = $auth0_api->get_authorize_link(
        // Response expected by the application.
        'code',
        // Callback URL to respond to.
        getenv('AUTH0_REDIRECT_URI'),
        // Connection to use, null for all.
        null,
        // State value to send with the request.
        $state_value,
        [
            // Respond with the code and state in a POST body.
            'response_mode' => 'form_post',
            // Userinfo to allow.
            'scope' => 'openid email profile',
        ]
    );

    header('Location: '.$authorize_url);
    exit;
}

echo '<h1>Sensitive data!</h1>';

/**
 * Determine if a user session exists.
 *
 * @return boolean
 */
function isUserAuthenticated()
{
    $store    = new SessionStore();
    $userinfo = $store->get('user');
    return ! empty( $userinfo );
}
