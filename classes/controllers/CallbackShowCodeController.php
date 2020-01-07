<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class CallbackShowCodeController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class CallbackShowCodeController extends GenericController
{
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {

        $this->tpl_vars['page'] = [
            'title' => 'Code',
            'content' => '<pre>' . $_GET['code'] . '</pre>',
        ];

        $this->render('page');
    }
}
