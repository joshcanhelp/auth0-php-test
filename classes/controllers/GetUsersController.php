<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class GetUsersController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class GetUsersController extends GenericController
{
    const DEFAULT_AVATAR_URL = 'https://www.gravatar.com/avatar/';

    /**
     * Handle get user output.
     *
     * @return mixed|void
     */
    public function handle()
    {
        try {
            $results = $this->callManagementApi()->users()->getAll([
                'sort' => 'created_at:-1',
            ]);
        } catch (\Exception $e) {
            $this->renderError($e);
            return;
        }

        foreach ($results as $index => $result) {
            $results[$index]['picture'] = self::DEFAULT_AVATAR_URL;
            if (isset($result['picture'])) {
                $results[$index]['picture'] = filter_var($result['picture'], FILTER_SANITIZE_URL);
            }

            $results[$index]['name'] = isset($result['name']) ? $result['name'] : '[Anonymous]';
        }

        $this->tpl_vars['users'] = [
            'title' => 'Users - Test PHP SDK',
            'results' => $results,
        ];

        $this->render('users');
    }
}
