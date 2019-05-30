<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class RootController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class RootController extends GenericController
{

    /**
     * Handle homepage output.
     *
     * @return void
     */
    public function handle()
    {
        $this->tpl_vars['home'] = [
            'title' => 'Home - Test PHP SDK',
            'links' => [ 'logs', 'users', 'grants', 'roles-test', 'users-test' ],
        ];
        $this->render('root');
    }
}
