<?php

namespace Auth0\SDK\Scaffold\Controllers;

/**
 * Class UsersTestController
 *
 * @package Auth0\SDK\Scaffold\Controllers
 */
class UsersTestController extends GenericController
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

            // Get a Roles
            $content .= '<h3>Get a Role</h3>';
            $api_results = $this->callManagementApi()->roles->getAll( [ 'per_page' => 1 ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $role_id = $api_results[0]['id'];

            // Get a User
            $content .= '<h3>Get a User</h3>';
            $api_results = $this->callManagementApi()->users->getAll( [
                'per_page' => 1,
                'fields' => 'user_id'
            ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $user_id = $api_results[0]['user_id'];

            // Add Role to User
            $content .= '<h3>Add Role to User</h3>';
            $this->callManagementApi()->users->addRoles( $user_id, [ $role_id ] );
            $content .= '<pre>SUCCESS ADDING ' . $role_id . ' TO ' . $user_id . '</pre>';

            // Get Roles for User
            $content .= '<h3>Get a Role</h3>';
            $api_results = $this->callManagementApi()->users->getRoles( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Remove Role from User
            $content .= '<h3>Remove Role from User</h3>';
            $this->callManagementApi()->users->removeRoles( $user_id, [ $role_id ] );
            $content .= '<pre>SUCCESS REMOVING ' . $role_id . ' FROM ' . $user_id . '</pre>';

            // Get Roles for User
            $content .= '<h3>Get Roles for User</h3>';
            $api_results = $this->callManagementApi()->users->getRoles( $user_id, [ 'include_totals' => null ] );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get Enrollments for User
            $content .= '<h3>Get Enrollments</h3>';
            $api_results = $this->callManagementApi()->users->getEnrollments( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get an APIs
            $content .= '<h3>Get APIs</h3>';
            $api_results = $this->callManagementApi()->resourceServers->getAll( 2, 1 );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            $api_id = $api_results[0]['identifier'];
            $permission_name = $api_results[0]['scopes'][0]['value'];
            $permissions = [
                [
                    'permission_name' => $permission_name,
                    'resource_server_identifier' => $api_id,
                ]
            ];

            // Add Permission to User
            $content .= '<h3>Add Permission to User</h3>';
            $this->callManagementApi()->users->addPermissions( $user_id, $permissions );
            $content .= '<pre>SUCCESS ADDING ' . $permission_name . ' TO ' . $user_id . '</pre>';

            // Get Permissions for User
            $content .= '<h3>Get Permissions for User</h3>';
            $api_results = $this->callManagementApi()->users->getPermissions( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Remove Permission from User
            $content .= '<h3>Remove Permission from User</h3>';
            $this->callManagementApi()->users->removePermissions( $user_id, $permissions );
            $content .= '<pre>SUCCESS REMOVING ' . $permission_name . ' FROM ' . $user_id . '</pre>';

            // Get Permissions for User
            $content .= '<h3>Get Permissions for User</h3>';
            $api_results = $this->callManagementApi()->users->getPermissions( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Get Logs for User
            $content .= '<h3>Get Logs for User</h3>';
            $api_results = $this->callManagementApi()->users->getLogs(
                $user_id,
                [
                    'per_page' => 2,
                    'fields' => 'date,type,ip'
                ]
            );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Generate Recovery Code
            $content .= '<h3>Generate Recovery Code</h3>';
            $api_results = $this->callManagementApi()->users->generateRecoveryCode( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

            // Invalidate Browsers
            $content .= '<h3>Invalidate Browsers</h3>';
            $api_results = $this->callManagementApi()->users->invalidateBrowsers( $user_id );
            $content .= '<pre>' . print_r( $api_results, TRUE ) . '</pre>';

        } catch (\Exception $e) {
            $this->renderError($e);
            return;
        }

        $this->tpl_vars['page'] = [
            'title' => 'User tests',
            'content' => $content,
        ];

        $this->render('page');
    }
}
