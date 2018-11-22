<?php

namespace Auth0\SDK\Scaffold\Controllers;

class RootController extends GenericController
{

    public function handle() {
        $this->tpl_vars['home'] = [
            'title' => 'Home - Test PHP SDK',
            'links' => [ 'logs', 'users' ]
        ];
        $this->render('root');
    }
}
