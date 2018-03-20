<?php
namespace Auth0\SDK\Scaffold;

final class ApiTestResourceServersGetAll extends ApiTestAbstract
{
    
    public function call() {
        $this->data = $this->api->resource_servers->getAll();
    }
  
    public function renderDataItem( $datum )
    {
        return sprintf(
            '<li><strong>%s</strong> - %s (%d scopes)</li>',
            $datum['name'],
            $datum['id'],
            ! empty( $datum['scopes'] ) ? count( $datum['scopes'] ) : 0
        );
    }
}