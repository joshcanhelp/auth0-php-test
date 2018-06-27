<?php
/**
 * index.php
 */
require 'bootstrap.php';

use Auth0\SDK\Scaffold\ApiTestClientsGetAll;

use Auth0\SDK\Scaffold\ApiTestConnectionsGetAll;

use Auth0\SDK\Scaffold\ApiTestEmailProviderGet;

use Auth0\SDK\Scaffold\ApiTestResourceServersGetAll;

use Auth0\SDK\Scaffold\ApiTestUserSearch;
use Auth0\SDK\Scaffold\ApiTestUserGet;
use Auth0\SDK\Scaffold\ApiTestUsersGetAll;
use Auth0\SDK\Scaffold\ApiTestUserCreate;
use Auth0\SDK\Scaffold\ApiTestUserUpdate;
use Auth0\SDK\Scaffold\ApiTestUserDelete;

use Auth0\SDK\Scaffold\ApiTestLogsSearch;

?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test PHP SDK</title>
    <link rel="stylesheet" href="//cdn.auth0.com/styleguide/core/2.0.5/core.min.css">
    <link rel="stylesheet" href="//cdn.auth0.com/styleguide/components/2.0.0/components.min.css">
    <link rel="stylesheet" href="main.css">

    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
</head>
<body>
<article>
    <h1>Auth0 Test Suite</h1>
    <p>Current PHP version <?php echo phpversion() ?></p>
    <hr>
    <?php if ($user = $auth0->getUser()) : ?>
        <h2>Logged In</h2>
        <ul>
            <?php
            foreach ($user as $key => $attr) {
                printf('<li><strong>%s:</strong> %s</li>', $key, $attr);
            }
            foreach (['access_token', 'id_token', 'refresh_token'] as $key) {
                printf('<li><strong>%s:</strong> %s</li>', $key, $_SESSION['auth0__' . $key]);
            }
            ?>
        </ul>
        <p><a href="?action=logout" class="btn btn-primary btn-sm">Logout</a>
            <a href="?action=renew" class="btn btn-primary btn-sm">Renew</a></p>
    <?php else : ?>
        <h2>Not Logged In</h2>
        <p><a href="?action=login" class="btn btn-primary btn-sm">Login</a></p>
    <?php endif; ?>
    <hr>

    <?php
    //    $email_provider_get = new ApiTestEmailProviderGet($mgmt_api, [], 'Email Provider - Get');
    //    $email_provider_get->render();
    //
    //    $client_get_all->render();
    //
    //    $connections_get_all = new ApiTestConnectionsGetAll($mgmt_api, [], 'Connections - Get All');
    //    $connections_get_all->render();
    //
    //    $res_servers_get_all = new ApiTestResourceServersGetAll($mgmt_api, [], 'Resource Servers - Get All');
    //    $res_servers_get_all->render();
    //
    //    $user_search = new ApiTestUserSearch(
    //        $mgmt_api, [
    //        'q' => 'email:"josh.cunningham@auth0.com"'
    //    ],
    //        'Users - Search');
    //    $user_search->render();
    //
    //    $user_create = new ApiTestUserCreate($mgmt_api, [
    //        'connection' => 'Username-Password-Authentication',
    //        'email' => 'josh+' . rand() . '@joshcanhelp.com',
    //        'password' => '1',
    //        'picture' => 'https://i0.heartyhosting.com/radaronline.com/wp-content/uploads/2011/08/stevejobs-5.jpg',
    //        'user_metadata' => [
    //            'key1' => 'value1',
    //            'key2' => 'value2',
    //        ]
    //    ], 'Users - Create');
    //    $user_create->render();
    //    $user_create_data = $user_create->getData();
    //
    //    $user_get = new ApiTestUserGet($mgmt_api, [ 'id' => $user_create_data['user_id'] ], 'Users - Get 1');
    //    $user_get->render();
    //
    //    $user_update = new ApiTestUserUpdate($mgmt_api, [
    //        'id' => $user_create_data['user_id'],
    //        'params' => [
    //            'email_verified' => true,
    //            'user_metadata' => [
    //                'key1' => 'value4',
    //                'key3' => 'value3',
    //            ]
    //        ]
    //    ], 'Users - Update');
    //    $user_update->render();
    //
    //    $user_delete = new ApiTestUserDelete($mgmt_api, [ 'id' => $user_create_data['user_id'] ], 'Users - Delete 1');
    //    $user_delete->render();

    //    $users_get_all = new ApiTestUsersGetAll($mgmt_api, [
    //        'params' => [
    //            'include_totals' => true
    //        ],
    //        'fields' => ['user_id', 'name', 'picture'],
    //        'include_fields' => true,
    //        'page' => 0,
    //        'per_page' => 30
    //    ], 'Users - Get All');
    //    $users_get_all->render();

    $logs_search = new ApiTestLogsSearch($mgmt_api, [
        'fields' => 'log_id,date,description',
        'include_fields' => true,
        'page' => 0,
        'per_page' => 30
    ], 'Logs - Search');
    $logs_search->render();
    ?>

</article>
</body>
</html>
