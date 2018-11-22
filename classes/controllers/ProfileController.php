<?php

namespace Auth0\SDK\Scaffold\Controllers;

class ProfileController extends GenericController
{

    /**
     * @return mixed|void
     */
    public function handle() {
        $this->tpl_vars['profile'] = [
            'title' => 'Profile - Test PHP SDK',
            'session' => print_r( $_SESSION, TRUE ),
        ];
        $this->render('profile');
    }
}
