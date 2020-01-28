<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class GetGrantsController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class GetGrantsController extends GenericController
{

    /**
     * Handle get user output.
     *
     * @return mixed|void
     */
    public function handle()
    {
        try {
            $results = $this->callManagementApi()->grants()->getAll();
        } catch (\Exception $e) {
            $this->renderError($e);
            return;
        }

        foreach ($results as $index => $result) {
            $results[$index]['scope'] = implode(' ', $result['scope']);

            $user_id = explode('|', $result['user_id']);
            $results[$index]['user_strategy'] = $user_id[0];
            $results[$index]['user_id'] = $user_id[1];
        }

        $this->tpl_vars['grants'] = [
            'title' => 'Grants - Test PHP SDK',
            'results' => $results,
        ];

        $this->render('grants');
    }
}
