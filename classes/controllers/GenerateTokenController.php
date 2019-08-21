<?php

namespace Auth0\SDK\Scaffold\Controllers;

use Auth0\SDK\API\Helpers\TokenGenerator;

/**
 * Class GenerateTokenController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class GenerateTokenController extends GenericController
{

    const ENV_SECRET_NAME = 'TEST_GLOBAL_CLIENT_SECRET';
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {

        if ( empty( getenv( self::ENV_SECRET_NAME ) ) ) {
            $this->render('page', [
                'title' => 'Generate API Token',
                'content' => '<strong>Need a <code>' . self::ENV_SECRET_NAME . '</code></strong>',
            ]);
            return;
        }

        $generator = new TokenGenerator( getenv( 'TEST_GLOBAL_CLIENT_ID' ), getenv( self::ENV_SECRET_NAME ) );
        $token = $generator->generate( [ 'clients' => [ 'actions' => [ 'read' ] ] ] );
        $content = sprintf( '<pre>%s</pre>', $token );

        $this->tpl_vars['page'] = [
            'title' => 'Generate API Token',
            'content' => $content,
        ];

        $this->render('page');
    }
}
