<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class CallbackShowDataController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class CallbackShowDataController extends GenericController
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
            'content' => '
                <h1>GET</h1>
                <pre>' . $_GET . '</pre>
                <h1>POST</h1>
                <pre>' . $_POST . '</pre>
                <h1>COOKIES</h1>
                <pre>' . $_COOKIE . '</pre>
                <h1>SESSION</h1>
                <pre>' . $_SESSION . '</pre>
                <h1>SERVER</h1>
                <pre>' . $_SERVER . '</pre>
            ',
        ];

        $this->render('page');
    }
}
