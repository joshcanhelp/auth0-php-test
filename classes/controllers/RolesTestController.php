<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class RolesTestController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class RolesTestController extends GenericController
{
    /**
     * Handle M-API logs output.
     *
     * @return void
     */
    public function handle()
    {

        $content = '';
        try {
            // Get all APIs
            $content .= '<h3>Get APIs</h3>';
            $api_results = $this->callManagementApi()->resourceServers->getAll( 2, 1 );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $api_id = $api_results[0]['identifier'];
            $permission_name = $api_results[0]['scopes'][0]['value'];

            // Create a new role
            $content .= '<h3>Create role</h3>';
            $api_results = $this->callManagementApi()->roles->create( 'Test Role ' . uniqid(), [ 'description' => 'Description' ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $role_id = $api_results['id'];

            // Get new role
            $content .= '<h3>Get role</h3>';
            $api_results = $this->callManagementApi()->roles->get( $role_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Update the new role
            $content .= '<h3>Update role</h3>';
            $api_results = $this->callManagementApi()->roles->update( $role_id, [ 'description' => 'New description' ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Add permissions to the role
            $content .= '<h3>Add permissions</h3>';
            $api_results = $this->callManagementApi()->roles->addPermissions(
                $role_id,
                [ [ 'permission_name' => $permission_name, 'resource_server_identifier' => $api_id ] ]
            );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get permissions for the role
            $content .= '<h3>Get permissions</h3>';
            $api_results = $this->callManagementApi()->roles->getPermissions( $role_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Remove permission
            $content .= '<h3>Remove permission</h3>';
            $api_results = $this->callManagementApi()->roles->removePermissions(
                $role_id,
                [ [ 'permission_name' => $permission_name, 'resource_server_identifier' => $api_id ] ]
            );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get a user
            $content .= '<h3>Get user</h3>';
            $api_results = $this->callManagementApi()->users->getAll( [
                'page' => 1,
                'per_page' => 1,
                'fields' => 'user_id'
            ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $user_id = $api_results[0]['user_id'];

            // Add user to the role
            $content .= '<h3>Add user</h3>';
            $api_results = $this->callManagementApi()->roles->addUsers( $role_id, [ $user_id ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get users for the role
            $content .= '<h3>Get users</h3>';
            $api_results = $this->callManagementApi()->roles->getUsers( $role_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Delete the role
            $content .= '<h3>Delete role</h3>';
            $api_results = $this->callManagementApi()->roles->delete( $role_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

        } catch (\Exception $e) {
            $content = $e->getResponse()->getBody()->getContents();
        }

        $this->tpl_vars['page'] = [
            'title' => 'Role tests',
            'content' => $content,
        ];

        $this->render('page');
    }
}
