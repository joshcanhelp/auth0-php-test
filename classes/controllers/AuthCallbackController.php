<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class AuthCallbackController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class AuthCallbackController extends GenericController
{
    /**
     * Handle the authentication callback.
     *
     * @return void
     *
     * @throws \Auth0\SDK\Exception\ApiException No access token returned from the API.
     * @throws \Auth0\SDK\Exception\CoreException Invalid state or exists session.
     */
    public function handle()
    {
        $redirect = BASE_URL;
        if ($this->auth0->getUser()) {
            $redirect .= '/profile';
        }

        header( 'Location: '.$redirect );
    }
}
