<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class LoginController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class LoginController extends GenericController
{

    /**
     * Handle the login redirect.
     *
     * @return void
     */
    public function handle()
    {
        $loginOpts = [
//            'redirect_uri' => BASE_URL . '/callback-idp-sso',
        ];
        $this->auth0->login(null, null, $loginOpts);

//        $auth_url = $this->auth0->getLoginUrl();
//        header('Location: ' . $auth_url);
//        exit;
    }
}
