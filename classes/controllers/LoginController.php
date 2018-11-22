<?php

namespace Auth0\SDK\Scaffold\Controllers;

class LoginController extends GenericController
{
    public function handle() {
        $this->auth0->login();
    }
}
