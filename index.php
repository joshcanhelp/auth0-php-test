<?php
/**
 * index.php
 */
require 'bootstrap.php';

use Auth0\SDK\Scaffold\ApiTestClientsGetAll;
use Auth0\SDK\Scaffold\ApiTestConnectionsGetAll;
use Auth0\SDK\Scaffold\ApiTestResourceServersGetAll;
use Auth0\SDK\Scaffold\ApiTestUserSearch;
use Auth0\SDK\Scaffold\ApiTestUserGet;
use Auth0\SDK\Scaffold\ApiTestEmailTemplateGet;

?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test PHP SDK</title>
    <link rel="stylesheet" href="//cdn.auth0.com/styleguide/core/2.0.5/core.min.css">
    <link rel="stylesheet" href="//cdn.auth0.com/styleguide/components/2.0.0/components.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<article>
    <h1>Auth0 Test Suite</h1>
    <p>Current PHP version <?php echo phpversion() ?></p>
    <?php if ($user = $auth0->getUser()) : ?>
        <h2>Logged In</h2>
        <ul>
            <?php
            foreach ($user as $key => $attr) {
                printf('<li><strong>%s:</strong> %s</li>', $key, $attr);
            }
            ?>
        </ul>
        <p><a href="?action=logout" class="btn btn-primary btn-sm">Logout</a></p>
    <?php else : ?>
        <h2>Not Logged In</h2>
        <p><a href="?action=login" class="btn btn-primary btn-sm">Login</a></p>
    <?php endif; ?>

    <?php
    $client_get_all = new ApiTestClientsGetAll([], 'Clients - Get All');
    $client_get_all->render();

    $connections_get_all = new ApiTestConnectionsGetAll([], 'Connections - Get All');
    $connections_get_all->render();

    $res_servers_get_all = new ApiTestResourceServersGetAll([], 'Resource Servers - Get All');
    $res_servers_get_all->render();

    $user_search = new ApiTestUserSearch(['q' => 'email:"josh.cunningham@auth0.com"'], 'Users - Search');
     $user_search->render();

    $get_user = new ApiTestUserGet([ 'id' => 'auth0|5a78b127ed65e34236bd2c2b' ], 'Users - Get One');
    $get_user->render();

    $get_email_tpl = new ApiTestEmailTemplateGet([ 'templateName' => 'verify_email' ], 'Email Template - Get One');
    $get_email_tpl->render();
    ?>

</article>
</body>
</html>
