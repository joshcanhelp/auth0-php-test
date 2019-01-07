<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class ProfileController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class ProfileController extends GenericController
{

    /**
     * Output the profile.
     *
     * @return void
     */
    public function handle()
    {
        $this->tpl_vars['profile'] = [
            'title'   => 'Profile - Test PHP SDK',
            'session' => print_r($_SESSION, true),
        ];
        $this->render('profile');
    }
}
