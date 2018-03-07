<?php
require 'bootstrap.php';

use Auth0\SDK\Scaffold\ApiTestClientGet;
use Auth0\SDK\Scaffold\ApiTestUserSearch;

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
    <?php if ( $user = $auth0->getUser() ) : ?>
        <h2>Logged In</h2>
        <ul>
            <?php
            foreach ( $user as $key => $attr ) {
                printf( '<li><strong>%s:</strong> %s</li>', $key, $attr );
            }
            ?>
        </ul>
        <p><a href="?action=logout" class="btn btn-primary btn-sm">Logout</a></p>
    <?php else : ?>
        <h2>Not Logged In</h2>
        <p><a href="?action=login" class="btn btn-primary btn-sm">Login</a></p>
    <?php endif; ?>
    
    <?php
    /*
     * Clients
     */
    
    $client_get_all = new ApiTestClientGet( [], 'Clients - Get All' );
    $client_get_all->render();
    
    /*
     * Users
     */
    
    $user_search = new ApiTestUserSearch( [
        'q' => 'email:"josh.cunningham@auth0.com"'
    ], 'Users - Search' );
    $user_search->render();
    ?>
    
</article>
</body>
</html>
