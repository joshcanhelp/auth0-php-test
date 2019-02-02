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
            'sort' => 'date:-1',
            'q' => '-client_id:uFRY5j2QEfADDsfT7J5Yk1Zumno2h5iU',
        ];

        if (! empty( $_GET['type'] )) {
            $params['q'] .= ' type:'.$_GET['type'];
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
            $date_split = explode('T', $result['date']);
            $date = explode('-', $date_split[0])[1] . '/' . explode('-', $date_split[0])[2];
            $time = explode('.', $date_split[1])[0];
            $results[$index]['date'] = $date . ' at ' . $time;
        }

        $this->tpl_vars['logs'] = [
            'title' => 'Logs - Test PHP SDK',
            'results' => $results,
            'manage_domain' => 'manage.'.(strpos(AUTH0_DOMAIN, 'local.dev') ? 'local.dev.' : '').'auth0.com',
        ];

        $this->render('logs');
    }
}
