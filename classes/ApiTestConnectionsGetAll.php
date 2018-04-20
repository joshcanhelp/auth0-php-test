<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestConnectionsGetAll extends ApiTestAbstract
{
    
    public function call() {
        $this->data = $this->api->connections->getAll();
    }
    
    public function renderDataItem( $datum )
    {
        return sprintf(
            '<li><strong>%s%s</strong> - %s - %d clients enabled</li>',
            $datum['name'],
            $datum['name'] !== $datum['strategy'] ? ' [' . $datum['strategy'] . ']' : '',
            $datum['id'],
            count( $datum['enabled_clients'] )
        );
    }
}