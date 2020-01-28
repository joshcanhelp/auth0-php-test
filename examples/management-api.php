<?php
require '../bootstrap.php';

// ======================================================================================================================
// Example #5
// management-examples.php
use Auth0\SDK\API\Management;

if ('test' === getenv('APPLICATION_ENVIRONMENT')) {
    // Use a temporary testing token.
    $access_token = getenv('AUTH0_MANAGEMENT_API_TOKEN');
} else {
    // See Authentication API page to implement this function.
    $access_token = getManagementAccessToken();
}

$mgmt_api = new Management($access_token, getenv('AUTH0_DOMAIN'));

// ======================================================================================================================
$results = $mgmt_api->users->search([
    'q' => 'josh'
]);

if (! empty($results)) {
    echo '<h2>User Search</h2>';
    foreach ($results as $datum) {
        printf(
            '<p><strong>%s</strong> &lt;%s&gt; - %s</p>',
            ! empty($datum['nickname']) ? $datum['nickname'] : 'No nickname',
            ! empty($datum['email']) ? $datum['email'] : 'No email',
            $datum['user_id']
        );
    }
}

// ======================================================================================================================
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
