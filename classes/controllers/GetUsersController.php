<?php

namespace Auth0\SDK\Scaffold\Controllers;

class GetUsersController extends GenericController
{
    /**
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function handle() {

        try {
            $results = $this->management->users->getAll([
                'sort' => 'created_at:-1',
            ]);
        } catch ( \Exception $e ) {
            $this->renderError($e);
            return;
        }

        foreach ( $results as $index => $result ) {
            $results[$index]['picture'] = isset( $result['picture'] ) ?
                filter_var( $result['picture'], FILTER_SANITIZE_URL ) :
                'https://www.gravatar.com/avatar/';

            $results[$index]['name'] = isset( $result['name'] ) ? $result['name'] : '[Anonymous]';
        }

        $this->tpl_vars['users'] = [
            'title' => 'Users - Test PHP SDK',
            'results' => $results,
        ];

        $this->render('users');
    }
}
