<?php

namespace Auth0\SDK\Scaffold\Controllers;

class RenewTokenController extends GenericController
{
    public function handle() {
        $this->auth0->renewTokens();
        header('Location: ' . $a0_redirect_uri);
    }
}
