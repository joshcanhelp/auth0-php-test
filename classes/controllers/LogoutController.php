<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\API\Authentication;

/**
 * Class LogoutController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class LogoutController extends GenericController
{
    /**
     * Handle the logout action.
     *
     * @return mixed|void
     */
    public function handle()
    {
        $this->auth0->logout();
        $authentication = new Authentication(AUTH0_DOMAIN, AUTH0_CLIENT_ID);
        header('Location: '.$authentication->get_logout_link(BASE_URL, AUTH0_CLIENT_ID));
        exit;
    }
}
