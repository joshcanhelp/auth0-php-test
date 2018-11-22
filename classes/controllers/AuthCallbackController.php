<?php

namespace Auth0\SDK\Scaffold\Controllers;

class AuthCallbackController extends GenericController
{
    /**
     * @return mixed|void
     *
     * @throws \Auth0\SDK\Exception\ApiException
     * @throws \Auth0\SDK\Exception\CoreException
     */
    public function handle() {
        $redirect = BASE_URL;
        if ( $this->auth0->getUser() ) {
            $redirect .= '/profile';
        }
        header( 'Location: ' . $redirect );
    }
}
