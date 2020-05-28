<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class RefreshTokenController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class RefreshTokenController extends GenericController
{

    /**
     * Refresh the tokens!
     *
     * @return mixed|void
     *
     * @throws \Auth0\SDK\Exception\ApiException
     * @throws \Auth0\SDK\Exception\CoreException
     */
    public function handle()
    {
        $tpl_vars = [
            'oldAccessToken' => $this->auth0->getAccessToken(),
            'oldIdToken' => $this->auth0->getIdToken(),
            'refreshToken' => $this->auth0->getRefreshToken(),
        ];

        $this->auth0->renewTokens();

        $tpl_vars['newAccessToken'] = $this->auth0->getAccessToken();
        $tpl_vars['newIdToken'] = $this->auth0->getIdToken();

        $this->tpl_vars['tokens'] = [
            'title'   => 'Refresh Token - Test PHP SDK',
            'session' => print_r($_SESSION, true),
        ] + $tpl_vars;

        $this->render('refreshToken');
    }
}
