<?php

namespace Auth0\SDK\Scaffold\Controllers;

class GetLogsController extends GenericController
{
    /**
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function handle() {

        $results = $this->management->logs->search([
            'fields' => 'type,description,auth0_client,client_id',
            'include_fields' => true,
            'page' => 0,
            'per_page' => 100,
            'sort' => 'date:-1'
        ]);

        foreach ( $results as $index => $result ) {
            $results[$index]['auth0_client'] = isset( $result['auth0_client'] ) ?
                json_encode( $result['auth0_client'] ) :
                'none';
        }

        $this->tpl_vars['logs'] = [
            'title' => 'Logs - Test PHP SDK',
            'results' => $results,
        ];

        $this->render('logs');
    }
}
