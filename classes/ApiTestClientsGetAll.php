<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestClientsGetAll extends ApiTestAbstract
{
    
    public function call() {
        $this->data = $this->api->clients->getAll();
    }
    
    public function renderDataItem( $datum )
    {
        return sprintf(
            '<li><strong>%s</strong> - %s</li>',
            $datum['name'],
            $datum['client_id']
        );
    }
}