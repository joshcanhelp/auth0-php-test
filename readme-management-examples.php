<?php
require __DIR__ . '/auth0/vendor/autoload.php';
use josegonzalez\Dotenv\Loader;

// Setup environment vars
$Dotenv = new Loader(__DIR__ . '/.env');
$Dotenv->parse()->putenv(true);

//======================================================================================================================

// Example #5
// management-examples.php
use Auth0\SDK\API\Management;

$access_token = getenv('AUTH0_MANAGEMENT_API_TOKEN');
$mgmt_api = new Management($access_token, getenv('AUTH0_DOMAIN'));

//======================================================================================================================

$results = $mgmt_api->users->search([
    'q' => 'josh'
]);

if (! empty($results)) {
    echo '<h2>User Search</h2>';
    foreach ($results as $datum) {
        printf(
            '<p><strong>%s</strong> &lt;%s&gt; - %s</p>',
            !empty($datum['nickname']) ? $datum['nickname'] : 'No nickname',
            !empty($datum['email']) ? $datum['email'] : 'No email',
            $datum['user_id']
        );
    }
}

//======================================================================================================================

$results = $mgmt_api->clients->getAll();

if (! empty($results)) {
    echo '<h2>Get All Clients</h2>';
    foreach ($results as $datum) {
        printf(
            '<p><strong>%s</strong> - %s</p>',
            $datum['name'],
            $datum['client_id']
        );
    }
}
