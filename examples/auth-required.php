<?php
require '../bootstrap.php';

// ======================================================================================================================
use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Auth0\SDK\Helpers\TransientStoreHandler;
use Auth0\SDK\Store\CookieStore;
use Auth0\SDK\Store\SessionStore;

if (! isUserAuthenticated()) {
    // Generate and store a state value.
    $transient_store = new CookieStore();
    $state_handler = new TransientStoreHandler($transient_store);
    $state_value = $state_handler->issue(Auth0::TRANSIENT_STATE_KEY);

    $auth0_api = new Authentication(
        getenv('AUTH0_DOMAIN'),
        getenv('AUTH0_CLIENT_ID')
    );

    // Generate the authorize URL.
    $authorize_url = $auth0_api->get_authorize_link(
        // Response requested by the application.
        'code',
        // Callback URL to respond to.
        getenv('AUTH0_REDIRECT_URI'),
        // Connection to use, null for all.
        null,
        // State value to send with the request.
        $state_value,
        [
            // Optional API Audience to get an access token.
            'audience' => 'https://' . getenv('AUTH0_DOMAIN') . '/api/v2/',
            // Adjust ID token scopes requested.
            'scope' => 'openid email address',
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
    return ! empty($userinfo);
}
