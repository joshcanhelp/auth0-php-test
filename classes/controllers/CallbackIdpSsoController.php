<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class CallbackIdpSsoController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class CallbackIdpSsoController extends GenericController
{
    /**
     * @return mixed|void
     * @throws \Auth0\SDK\Exception\ApiException
     * @throws \Auth0\SDK\Exception\CoreException
     */
    public function handle()
    {

        if ($_GET['idp_initiated_sso'] ?? false) {
            $_COOKIE['auth0__state'] = 'bypass';
            $_COOKIE['auth0__nonce'] = 'bypass';
            $_GET['state'] = 'bypass';
        } else {
            $queryParams = [
                'code' => $_GET['code'],
                'idp_initiated_sso' => 1,
            ];
            $redirectUrl = BASE_URL . '/callback-idp-sso?'.http_build_query($queryParams);
            header('Location: '.$redirectUrl);
            exit;
        }

        $this->auth0->exchange();

        $this->tpl_vars['page'] = [
            'title' => 'IdP Initiated SSO',
            'content' =>
                '<pre>' . $this->auth0->getIdToken() . '</pre>' .
                '<pre>' . print_r($_COOKIE, true) . '</pre>' .
                '<pre>' . print_r($_REQUEST, true) . '</pre>' .
                '<pre>' . print_r($_SERVER, true) . '</pre>'
        ];

        $this->render('page');
    }
}
