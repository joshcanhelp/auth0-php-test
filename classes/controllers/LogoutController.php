<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\API\Authentication;

class LogoutController extends GenericController
{
    public function handle() {
        $this->auth0->logout();
        $authentication = new Authentication( AUTH0_DOMAIN, AUTH0_CLIENT_ID );
        header( 'Location: ' . $authentication->get_logout_link( BASE_URL, AUTH0_CLIENT_ID ) . '&auth0Client=eyJuYW1lIjoiYXV0aDAtcGhwIiwidmVyc2lvbiI6IjUuMy4yIiwiZW52Ijp7InBocCI6IjcuMS4xNiJ9fQo=' );
        exit;
    }
}
