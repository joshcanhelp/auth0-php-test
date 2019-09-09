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
        $this->auth0->login(null, null, [ 'nonce' => uniqid() ]);
    }
}
