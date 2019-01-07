<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class GetLogsController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class GetLogsController extends GenericController
{
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {
        $params = [
            'page' => 0,
            'per_page' => 100,
            'sort' => 'date:-1'
        ];

        if (! empty( $_GET['type'] )) {
            $params['q'] = 'type:'.$_GET['type'];
        }

        try {
            $results = $this->management->logs->search($params);
        } catch (\Exception $e) {
            $this->renderError($e);
            return;
        }

        foreach ($results as $index => $result) {
            $results[$index]['auth0_client'] = 'none';
            if (isset( $result[$index]['auth0_client'] )) {
                $results[$index]['auth0_client'] = json_encode( $result[$index]['auth0_client'] );
            }

            $results[$index]['date'] = explode('.', explode('T', $result['date'])[1])[0];
        }

        $this->tpl_vars['logs'] = [
            'title' => 'Logs - Test PHP SDK',
            'results' => $results,
            'manage_domain' => 'manage.'.(strpos(AUTH0_DOMAIN, 'local.dev') ? 'local.dev.' : '').'auth0.com',
        ];

        $this->render('logs');
    }
}
